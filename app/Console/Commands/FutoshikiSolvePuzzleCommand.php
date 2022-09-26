<?php

namespace App\Console\Commands;

use App\CrossSums\InvalidOperatorException;
use App\CrossSums\Puzzle;
use App\CrossSums\PuzzleSolver;
use App\CrossSums\Riddle;
use App\CrossSums\RiddleSnapshot;
use App\CrossSums\Validators\CellValuesMatchAcrossRiddleSnapshotsValidator;
use App\CrossSums\Validators\CompareRiddleCellsValidator;
use App\CrossSums\Validators\InvalidCellIndexException;
use App\CrossSums\Validators\PuzzleSnapshotHasValidRiddleSnapshotsValidator;
use App\CrossSums\Validators\PuzzleSnapshotValidator;
use App\CrossSums\Validators\UniqueValuesAcrossPuzzleSnapshotValidator;
use App\Futoshikis\Helpers\GridConsoleDisplayTableRenderer;
use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;
use App\Futoshikis\Models\Rule;
use App\Futoshikis\Solvers\GridSolver;
use App\Futoshikis\Solvers\Strategies\RemoveImpossibleMarksBasedOnRules;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenMarkAloneInCol;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenMarkAloneInRow;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenSingleMarkLeft;
use App\Futoshikis\Solvers\Strategies\UpdateMarksBasedOnHorizontalCells;
use App\Futoshikis\Solvers\Strategies\UpdateMarksBasedOnVerticalCells;
use Illuminate\Console\Command;

class FutoshikiSolvePuzzleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'futoshiki:solve {size} {definitions*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Solves a full puzzle futoshiki by specifying the definitions. A definition is either an initializer (x,y)=number or a rule (x,y)<(x,y)';
    private int $size;
    private Grid $grid;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (!$this->parseSize()) {
            return 1;
        }
        $this->output->info('Size = ' . $this->size);
        $this->grid = new Grid($this->size);

        foreach ($this->argument('definitions') as $definition)
        {
            if (str_contains($definition, '=')) {
                if (!$this->parseInitializerDefinition($definition)) {
                    return 1;
                }
            } elseif (str_contains($definition, '<')) {
                list($lesserPositionString, $greaterPositionString) = explode('<', $definition);



                if (!preg_match('/\(\d,\d\)/', $lesserPositionString)) {
                    $this->error('The lesser position of the rule ' . $definition . ' must follow the format (x,y)');
                    return false;
                }
                list($lesserX, $lesserY) = explode(',', str_replace(['(', ')'], '', $lesserPositionString));
                if (!is_numeric($lesserX)) {
                    $this->error('X of lesser position rule ' . $definition . ' must be a number');
                    return false;
                }
                if (!is_numeric($lesserY)) {
                    $this->error('Y of lesser position rule ' . $definition . ' must be a number');
                    return false;
                }
                $lesserX = (int)$lesserX;
                $lesserY = (int)$lesserY;
                if (!in_array($lesserX, range(1, $this->grid->size))) {
                    $this->error('X of rule ' . $definition . ' must be a number between 1 and the grid size');
                    return false;
                }
                if (!in_array($lesserY, range(1, $this->grid->size))) {
                    $this->error('Y of rule ' . $definition . ' must be a number between 1 and the grid size');
                    return false;
                }



                if (!preg_match('/\(\d,\d\)/', $greaterPositionString)) {
                    $this->error('The lesser position of the rule ' . $definition . ' must follow the format (x,y)');
                    return false;
                }
                list($greaterX, $greaterY) = explode(',', str_replace(['(', ')'], '', $greaterPositionString));
                if (!is_numeric($greaterX)) {
                    $this->error('X of greater position rule ' . $definition . ' must be a number');
                    return false;
                }
                if (!is_numeric($greaterY)) {
                    $this->error('Y of greater position rule ' . $definition . ' must be a number');
                    return false;
                }
                $greaterX = (int)$greaterX;
                $greaterY = (int)$greaterY;
                if (!in_array($greaterX, range(1, $this->grid->size))) {
                    $this->error('X of rule ' . $definition . ' must be a number between 1 and the grid size');
                    return false;
                }
                if (!in_array($greaterY, range(1, $this->grid->size))) {
                    $this->error('Y of rule ' . $definition . ' must be a number between 1 and the grid size');
                    return false;
                }

                $rule = new Rule(new GridPosition($lesserX - 1, $lesserY - 1), new GridPosition($greaterX - 1, $greaterY - 1));
                $this->grid->addRule($rule);

            } else {
                $this->output->error('Invalid definition see help for valid initializer or rule structure: ' . $definition);
            }
        }
        $renderer = new GridConsoleDisplayTableRenderer();
        $this->output->write($renderer->render($this->grid));

        $solver = new GridSolver(
            new UpdateMarksBasedOnHorizontalCells(),
            new UpdateMarksBasedOnVerticalCells(),
            new RemoveImpossibleMarksBasedOnRules(),
            new SolveCellWhenSingleMarkLeft(),
            new SolveCellWhenMarkAloneInRow(),
            new SolveCellWhenMarkAloneInCol()
        );
        $solver->solve($this->grid);

        return 0;
    }

    /**
     * @return bool
     */
    public function parseSize(): bool
    {
        $size = $this->argument('size');
        if (!is_numeric($size)) {
            $this->output->error('Size must be a number between 4 and 9 included');
            return false;
        }
        $this->size = (int)$size;
        if ($this->size < 4 || $this->size > 9) {
            $this->output->error('Size must be between 4 and 9 included');
            return false;
        }
        return true;
    }

    /**
     * @param string $definition
     * @return bool
     */
    public function parseInitializerDefinition(string $definition): bool
    {
        list($positionString, $value) = explode('=', $definition);
        if (!is_numeric($value)) {
            $this->error('value of initializer ' . $definition . ' must be a number');
            return false;
        }
        $value = (int)$value;
        if (!in_array($value, range(1, $this->grid->size))) {
            $this->error('value of initializer ' . $definition . ' must be a number between 1 and the grid size');
            return false;
        }
        if (!preg_match('/\(\d,\d\)/', $positionString)) {
            $this->error('The position of the initializer ' . $definition . ' must follow the format (x,y)');
            return false;
        }
        list($x, $y) = explode(',', str_replace(['(', ')'], '', $positionString));
        if (!is_numeric($x)) {
            $this->error('X of initializer position ' . $definition . ' must be a number');
            return false;
        }
        if (!is_numeric($y)) {
            $this->error('Y of initializer position ' . $definition . ' must be a number');
            return false;
        }
        $x = (int)$x;
        $y = (int)$y;
        if (!in_array($x, range(1, $this->grid->size))) {
            $this->error('X of initializer ' . $definition . ' must be a number between 1 and the grid size');
            return false;
        }
        if (!in_array($y, range(1, $this->grid->size))) {
            $this->error('Y of initializer ' . $definition . ' must be a number between 1 and the grid size');
            return false;
        }
        $this->grid->getCell(new GridPosition($x - 1, $y - 1))->setValue($value);
        return true;
    }
}
