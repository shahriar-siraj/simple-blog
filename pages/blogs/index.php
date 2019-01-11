<?php include '../../config.php'; ?>
<?php include '../layouts/header.php'; ?>

<div class="container" ng-app="myApp" ng-controller="blogController">
    <h3>Blogs</h3>
    <p>Here you can read all the blogs</p>
    
    <div class="row" ng-if="blogs != null">
        <div class="col-md-6" ng-repeat="blog in blogs">
            <div class="panel panel-default panel-custom">
                <div class="panel-heading">{{ blog.title }}</div>
                <div class="panel-body">
                    <p>
                        <strong>{{ blog.admin_name }}</strong>
                    </p>
                    {{ blog.short_content }}

                    <br>
                    <a href="<?php echo BASE_URL.'/blog/'; ?>{{ blog.id }}">
                        <small>Read more</small>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row text-center" style="margin-top: 30px;" ng-if="!blogs || blogs.length == 0">
        <small>No blogs to display</small>
    </div>
</div>

<?php include '../layouts/scripts.php'; ?>

<!-- AngularJS Code -->
<script>
    var app = angular.module('myApp', []);
    app.controller('blogController', function($scope, $http) {
        $scope.blogs = null;
        
        /**
         * Gets the list of blogs
         */
        $http.get("<?php echo BASE_URL.'/api/blog'; ?>")
        .then(function(response) {
            console.log(response.data);
            
            $scope.blogs = response.data;
        });
    });
</script>

<?php include '../layouts/footer.php'; ?>