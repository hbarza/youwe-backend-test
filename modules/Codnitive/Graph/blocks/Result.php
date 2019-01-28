<?php 
/**
 * Graph string analyzer form block
 *
 * @author Omid Barza <hbarza@gmail.com>
 */
namespace app\modules\Codnitive\Graph\blocks;

use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Graph\models\Graph;

class Result extends Template
{
    public function drawGraph(Graph $graphStatistics, string $html): string
    {
        if (empty($graph)) {
            return $html;
        }
        dump($graph->getStatistics(false));
        exit;
        $html = '';
        foreach ($graph->getStatistics(false) as $charahter => $info) {
            $html .= "<div>$charahter</div>";
        }
    }
}
