<?php include '../../config.php'; ?>
<?php include '../layouts/admin_header.php'; ?>

<style>
body 
{
    background: #fff;
}

.login-card 
{
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    -webkit-box-shadow: 0 15px 20px rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0 15px 20px rgba(0, 0, 0, 0.3);
    box-shadow: 0 15px 20px rgba(0, 0, 0, 0.3); 
}

.btn-custom
{
    color: #fff;
    background: #45B69C;
    border: none;
}

.navbar-custom
{
    color: #fff;
    background: #45B69C;
    border: none;
}

.navbar-custom .navbar-brand
{
    color: #fff;
    font-family: 'Pacifico', cursive;
}

.navbar-custom .navbar-nav>li>a
{
    color: #fff;
}

@media (min-width: 768px)
{
    .navbar 
    {
        border-radius: 0;
    }
}
</style>

<nav class="navbar navbar-inverse navbar-custom">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="">Admin Panel</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#" onclick="logout()"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container" ng-app="myApp" ng-controller="adminBlogController" style="">
    <div class="row">
        <div class="col-md-12">
            <h3>Blogs</h3>
            <p>Here you can create, update, read or delete blogs</p>

            <div class="alert alert-success" ng-if="blogs_success">
                <strong>Success!</strong> {{ blogs_success }}
            </div>
            <div class="alert alert-danger" ng-if="blogs_error">
                <strong>Error!</strong> {{ blogs_error }}
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="blog in blogs">
                            <td>{{ $index+1 }}</td>
                            <td>{{ blog.short_title }}</td>
                            <td>{{ blog.short_content }}</td>
                            <td>{{ blog.created_at}}</td>
                            <td>{{ blog.updated_at}}</td>
                            <td>
                                <button class="btn btn-xs btn-default" ng-click="show_read_blog_modal(blog.id)"><i class="far fa-eye"></i></button>
                                <button class="btn btn-xs btn-primary" ng-click="show_update_blog_modal(blog.id)"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-xs btn-danger" ng-click="delete_blog(blog.id)"><i class="far fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button class="btn btn-default btn-custom" ng-click="show_create_blog_modal()">Create New Blog</button>
        </div>
    </div>

    <div id="createBlogModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create New Blog</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" ng-if="new_blog_error">
                        <strong>Error!</strong> {{ new_blog_error }}
                    </div>
                    <div class="form-group">
                        <label for="usr">Title:</label>
                        <input type="text" class="form-control" ng-model="new_blog.title">
                    </div>
                    <div class="form-group">
                        <label for="comment">Content:</label>
                        <textarea class="form-control" rows="5" ng-model="new_blog.content"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-custom" ng-click="create_blog()">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    
    <div id="updateBlogModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Blog</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" ng-if="blog_error">
                        <strong>Error!</strong> {{ blog_error }}
                    </div>
                    <div class="form-group">
                        <label for="usr">Title:</label>
                        <input type="text" class="form-control" ng-model="blog.title">
                    </div>
                    <div class="form-group">
                        <label for="comment">Content:</label>
                        <textarea class="form-control" rows="5" ng-model="blog.content"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-custom" ng-click="update_blog()">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    
    <div id="readBlogModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ blog.title }}</h4>
                </div>
                <div class="modal-body">
                    <p style="white-space: pre-line;">{{ blog.content }}</p>
                    <p>
                        <strong>Published by: </strong> {{ blog.admin_name }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    
</div>

<?php include '../layouts/scripts.php'; ?>

<!-- AngularJS Code -->
<script>
    var app = angular.module('myApp', []);

    app.controller('adminBlogController', function($scope, $http) {
        $scope.admin = null;
        $scope.blogs = null;

        $scope.new_blog = {
            title: null,
            content: null
        };
        $scope.blog = {
            title: null,
            content: null
        };

        $scope.new_blog_error = null;
        $scope.blog_error = null;
        $scope.blogs_success = null;
        $scope.blogs_error = null;
        
        /**
         * Guards this route from unauthenticated access
         */
        $scope.route_guard = function () {
            var admin_id = sessionStorage.getItem('admin_id');

            if (!admin_id) {
                window.location.href = "<?php echo BASE_URL.'/admin/'; ?>"
            }
        }
        
        /**
         * Gets the list of blogs
         */
        $scope.get_blogs = function () {
            $http.get("<?php echo BASE_URL.'/api/blog'; ?>")
            .then(function(response) {
                console.log(response.data);
                
                $scope.blogs = response.data;
            });
        }
        
        /**
         * Shows the create blog modal
         */
        $scope.show_create_blog_modal = function () {
            $('#createBlogModal').modal('show');
        }
        
        /**
         * Hides the create blog modal
         */
        $scope.hide_create_blog_modal = function () {
            $('#createBlogModal').modal('hide');
        }
        
        /**
         * Gets the blog details based on id and
         * Shows the update blog modal
         */
        $scope.show_update_blog_modal = function (id) {
            
            $http.get("<?php echo BASE_URL.'/api/blog/'; ?>" + id)
            .then(function(response) {
                console.log(response.data);
                
                $scope.blog = response.data;

                $('#updateBlogModal').modal('show');
            });
        }
        
        /**
         * Hides the update blog modal
         */
        $scope.hide_update_blog_modal = function () {
            $('#updateBlogModal').modal('hide');
        }
        
        /**
         * Gets the blog details based on id and
         * Shows the read blog modal
         */
        $scope.show_read_blog_modal = function (id) {
            
            $http.get("<?php echo BASE_URL.'/api/blog/'; ?>" + id)
            .then(function(response) {
                console.log(response.data);
                
                $scope.blog = response.data;

                $('#readBlogModal').modal('show');
            });
        }
        
        /**
         * Creates a new blog
         */
        $scope.create_blog = function () {
            if (!$scope.new_blog.title || $scope.new_blog.title.length == 0) {
                $scope.new_blog_error = 'Title cannot be empty!';
            }
            else if (!$scope.new_blog.content || $scope.new_blog.content.length < 10) {
                $scope.new_blog_error = 'Content length cannot be less than 10';
            }
            else {
                $scope.new_blog_error = null;

                $scope.new_blog.admin_id = sessionStorage.getItem('admin_id');

                $http({
                    method: 'POST',
                    url: "<?php echo BASE_URL.'/api/blog/create'; ?>",
                    data: JSON.stringify($scope.new_blog)
                })
                .then(function (response) {
                    console.log(response.data);

                    $scope.get_blogs();
                    $scope.hide_create_blog_modal();
                    $scope.blogs_success = response.data.message;
                }, function (response) {
                    console.log(response.data);

                    $scope.new_blog_error = response.data.message;
                });
            }
        }
        
        /**
         * Updates requested blog
         */
        $scope.update_blog = function () {
            if (!$scope.blog.title || $scope.blog.title.length == 0) {
                $scope.blog_error = 'Title cannot be empty!';
            }
            else if (!$scope.blog.content || $scope.blog.content.length < 10) {
                $scope.blog_error = 'Content length cannot be less than 10';
            }
            else {
                $scope.blog_error = null;

                $http({
                    method: 'POST',
                    url: "<?php echo BASE_URL.'/api/blog/update'; ?>",
                    data: JSON.stringify($scope.blog)
                })
                .then(function (response) {
                    console.log(response.data);

                    $scope.get_blogs();
                    $scope.hide_update_blog_modal();
                    $scope.blogs_success = response.data.message;
                }, function (response) {
                    console.log(response.data);

                    $scope.new_blog_error = response.data.message;
                });
            }
        }
        
        /**
         * Deletes requested blog
         */
        $scope.delete_blog = function (id) {

            $data = {
                'id': id
            };

            $http({
                method: 'POST',
                url: "<?php echo BASE_URL.'/api/blog/delete'; ?>",
                data: JSON.stringify($data)
            })
            .then(function (response) {
                console.log(response.data);

                $scope.get_blogs();
                $scope.blogs_success = response.data.message;
            }, function (response) {
                console.log(response.data);

                $scope.blogs_error = response.data.message;
            });
        }

        $scope.route_guard(); 
        $scope.get_blogs(); 
    });

    /**
     * Logs out Admin Session
     */
    function logout() {
        sessionStorage.removeItem('admin_id');
        
        window.location.reload();
    }
</script>

<?php include '../layouts/footer.php'; ?>