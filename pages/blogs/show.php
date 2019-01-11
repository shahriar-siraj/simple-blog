<?php include '../../config.php'; ?>
<?php include '../layouts/header.php'; ?>

<div class="container" ng-app="myApp" ng-controller="blogController">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-custom">
                <div class="panel-heading">{{ blog.title }}</div>
                <div class="panel-body">
                    <p>
                        <strong>{{ blog.admin_name }}</strong> <br>
                        <small>{{ blog.created_at }}</small>
                    </p>
                    
                    <span style="white-space: pre-line;">{{ blog.content }}</span>
                </div>
            </div>
        </div>
    </div>
    
    
</div>

<?php include '../layouts/scripts.php'; ?>

<!-- AngularJS Code -->
<script>
    var app = angular.module('myApp', []);
    app.controller('blogController', function($scope, $http) {
        $scope.blog = null;
        
        /**
         * Gets a single blog based on ID
         */
        $http.get("<?php echo BASE_URL.'/api/blog/'.$_GET['id']; ?>")
        .then(function(response) {
            console.log(response.data);
            
            $scope.blog = response.data;
        });
    });
</script>

<?php include '../layouts/footer.php'; ?>