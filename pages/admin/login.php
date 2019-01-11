<?php include '../../config.php'; ?>
<?php include '../layouts/admin_header.php'; ?>

<style>
body 
{
    background: #45B69C;
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
</style>

<div class="container" ng-app="myApp" ng-controller="adminController" style="margin-top: 100px;">
    <div class="row text-center">
        <h2 style="padding: 30px 0; color: #fff; font-family: 'Pacifico', cursive;">Admin Panel</h2>
    </div>
    <div id="loginDiv" class="row">
        <div class="col-md-4 col-md-offset-4 login-card">
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" ng-model="admin.email">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" ng-model="admin.password">
            </div>

            <div class="alert alert-danger" ng-if="login_error">
                <strong>Error!</strong> {{ login_error.message }}
            </div>
            
            <button type="button" class="btn btn-default btn-custom text-center" ng-click="auth()">Login</button>
            
            <hr>
            <strong>Not a member? </strong>
            <button type="button" class="btn btn-warning text-center" ng-click="show_register_card()">Register Now</button>
        </div>
    </div>

    <div id="registerDiv" class="row" style="display: none;">
        <div class="col-md-4 col-md-offset-4 login-card">
            
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" class="form-control" ng-model="admin.name">
            </div>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" ng-model="admin.email">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" ng-model="admin.password">
            </div>

            <div class="alert alert-danger" ng-if="login_error">
                <strong>Error!</strong> {{ login_error }}
            </div>
            
            <button type="button" class="btn btn-default btn-custom text-center" ng-click="register()">Register</button>
            
            <hr>
            <strong>Already a member? </strong>
            <button type="button" class="btn btn-warning text-center" ng-click="show_login_card()">Login Now</button>
        </div>
    </div>
    
</div>

<?php include '../layouts/scripts.php'; ?>

<!-- AngularJS Code -->
<script>
    var app = angular.module('myApp', []);
    app.controller('adminController', function($scope, $http) {
        $scope.admin = {
            name: null,
            email: null,
            password: null
        };
        $scope.login_error = null;
            
        /**
         * Authenticates admin
         */
        $scope.auth = function() {
            $http({
                method: 'POST',
                url: "<?php echo BASE_URL.'/api/admin/login'; ?>",
                data: JSON.stringify($scope.admin)
            })
            .then(function (response) {
                console.log(response.data);

                sessionStorage.setItem('admin_id', response.data.id);
                $scope.login_error = null;

                $scope.route_guard();
                
            }, function (response) {
                console.log(response.data);

                $scope.login_error = response.data;
            });
        };
        
        /**
         * Registers a new admin
         */
        $scope.register = function() {
            if (!$scope.admin.name || $scope.admin.name.length == 0) {
                $scope.login_error = 'Full name cannot be empty!';
            }
            else if (!$scope.admin.email || !$scope.validate_email($scope.admin.email)) {
                $scope.login_error = 'Email address is invalid!';
            }
            else if (!$scope.admin.password || $scope.admin.password.length < 6) {
                $scope.login_error = 'Password length cannot be less than 6!';
            }
            else 
            {
                $http({
                    method: 'POST',
                    url: "<?php echo BASE_URL.'/api/admin/register'; ?>",
                    data: JSON.stringify($scope.admin)
                })
                .then(function (response) {
                    console.log(response.data);
    
                    sessionStorage.setItem('admin_id', response.data.id);
                    $scope.login_error = null;
    
                    $scope.route_guard();
                    
                }, function (response) {
                    console.log(response.data);
    
                    $scope.login_error = response.data.message;
                });
            }

        };
        
        /**
         * Route guard to redirect to dashboard if logged in already
         */
        $scope.route_guard = function () {
            var admin_id = sessionStorage.getItem('admin_id');

            if (admin_id) {
                window.location.href = "<?php echo BASE_URL.'/admin/dashboard'; ?>"
            }
        }
        
        /**
         * Shows Registration Card
         */
        $scope.show_register_card = function () {
            $('#loginDiv').slideUp(400);
            $('#registerDiv').delay(500).slideDown(400);
        }
        
        /**
         * Shows Login Card
         */
        $scope.show_login_card = function () {
            $('#registerDiv').slideUp(400);
            $('#loginDiv').delay(500).slideDown(400);
        }
        
        /**
         * Validates Email
         */
        $scope.validate_email = function (email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            return re.test(String(email).toLowerCase());
        }

        $scope.route_guard(); 
    });
</script>

<?php include '../layouts/footer.php'; ?>