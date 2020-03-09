<?php

namespace Needham\ModelDoc\Commands;

use Illuminate\Console\Command;
use Needham\ModelDoc\Database\Inspector;
use Needham\ModelDoc\Doc;
use Needham\ModelDoc\Models\Discovery;
use Needham\ModelDoc\Writer\Output;

class DocModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doc:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Document all models';
    /**
     * @var Discovery
     */
    private $discovery;
    /**
     * @var Inspector
     */
    private $inspector;
    /**
     * @var Output
     */
    private $writer;

    /**
     * Create a new command instance.
     *
     * @param Discovery $discovery
     * @param Inspector $inspector
     * @param Output $output
     */
    public function __construct(
        Discovery $discovery,
        Inspector $inspector,
        Output $writer
    )
    {
        parent::__construct();
        $this->discovery = $discovery;
        $this->inspector = $inspector;
        $this->writer = $writer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $models = $this->discovery->fetch();

        /**
         * Go through each model and find whats on its DB schema
         */
        foreach ($models as $model) {
            $attributes = $this->inspector->inspect($model);

            $doc = new Doc($model, $attributes);

            if (count($attributes)) {
                $this->writer->write($doc);
            }
        }
    }
}
