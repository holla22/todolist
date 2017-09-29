//Define an angular module for our app
var app = angular.module('myApp', []);

app.controller('tasksController', function($scope, $http, $filter) {
  getTask(); // Load all available tasks 
  function getTask() {  
  $http.post("php/getTask.php").then(function(data){
        $scope.tasks = data.data;

        console.log($scope.tasks);
       });
  };
  $scope.addTask = function (task) {
    $http.post("php/addTask.php?task="+task).then(function(data){
        getTask();
        $scope.taskInput = "";
      });
  };
  $scope.deleteTask = function (task) {
    if(confirm("Are you sure to delete this line?")){
    $http.post("php/deleteTask.php?taskID="+task).then(function(data){
        getTask();
      });
    }
  };

  $scope.toggleStatus = function(item, status, task) {
    if(status=='2'){status='0';}else{status='2';}
      $http.post("php/updateTask.php?taskID="+item+"&status="+status).then(function(data){
        getTask();
      });
     // check if an item was selected or not
     $scope.isAllSelected = $scope.tasks.every(function(itm){ return itm.selected; });

  };

  // SELECT ALL || UNSELECT ALL
  $scope.toggleAll = function() {
     var toggleStatus = $scope.isAllSelected;
     
     angular.forEach($scope.tasks, function(itm){ 

       console.log(itm);
       itm.selected = toggleStatus; 


       if(itm.STATUS!=='2' && itm.selected == true)
       {
         itm.STATUS='2';
         // UPDATE all SELECTED
         $http.post("php/updateTask.php?taskID="+itm.ID+"&status="+itm.STATUS).then(function(data){
          getTask();
         });
       }
       else if(itm.selected == false)
       {
         itm.STATUS='0';
         // UPDATE all SELECTED
         $http.post("php/updateTask.php?taskID="+itm.ID+"&status="+itm.STATUS).then(function(data){
          getTask();
         });
        
       }
        
      });
  };

});
