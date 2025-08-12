<?php
/**
 * Project Name: 19k5 Build a Real-Time Data Visualization Analyzer
 * Description: A PHP-based real-time data visualization analyzer that fetches data from a MongoDB database and 
 *              displays it in a interactive graph using Highcharts.
 * Author: [Your Name]
 * Date: [Current Date]
 */

// Configuration
$dbHost = 'localhost';
$dbName = 'realtime_data';
$collectionName = 'visualization_data';
$chartTitle = 'Real-Time Data Visualization';
$chartSubtitle = 'Interactive graph displaying real-time data';

// Connect to MongoDB
$mongo = new MongoClient("mongodb://$dbHost");
$db = $mongo->$dbName;
$collection = $db->$collectionName;

// Function to retrieve real-time data from MongoDB
function getRealtimeData() {
    $cursor = $collection->find();
    $data = array();
    foreach ($cursor as $document) {
        $data[] = array('x' => $document['timestamp'], 'y' => $document['value']);
    }
    return $data;
}

// Function to generate Highcharts graph
function generateChart($data) {
    ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <div id="chart" style="width: 100%; height: 400px;"></div>
    <script>
        Highcharts.chart('chart', {
            chart: {
                type: 'line'
            },
            title: {
                text: '<?= $chartTitle ?>'
            },
            subtitle: {
                text: '<?= $chartSubtitle ?>'
            },
            xAxis: {
                type: 'datetime'
            },
            series: [{
                data: <?= json_encode($data) ?>
            }]
        });
    </script>
    <?php
}

// Main execution
$data = getRealtimeData();
generateChart($data);

?>