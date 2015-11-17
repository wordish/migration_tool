<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\PageFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\SinglePageFormatter;

/**
 * @Entity
 */
class SinglePageObjectCollection extends PageObjectCollection
{


    public function getType()
    {
        return 'single_page';
    }

    public function getFormatter()
    {
        return new SinglePageFormatter($this);
    }

}