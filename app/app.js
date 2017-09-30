//Define an angular module for our app
var app = angular.module('myApp', []);


app.controller('tasksController', function($scope, $http, $filter) {

  // getTasks method for getting all tasks
  getTask(); // Load all available tasks 
  function getTask() {  
  var data = {
    type:'get'
  };

  var req = {
    method: 'POST',
    url: 'php/main.php',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8',
      'X-API-KEY' : 'ac54bcf346e578feb46888b3ecd2344f'
    },
    data: { type: 'get' }
  }
  $http(req).then(function(data){
        $scope.tasks = data.data;

        console.log($scope.tasks);
       });
  };

  // addTask method for adding tasks
  $scope.addTask = function (task) { 
      // set request parameters      
      var req = {
        method: 'POST',
        url: 'php/main.php',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8',
          'X-API-KEY' : 'ac54bcf346e578feb46888b3ecd2344f'
        },
        data: { type: 'add', task: task }
      }

    $http(req).then(function(data){
        getTask();
        $scope.taskInput = "";
      });
  };

  // deleteTask method for deleting tasks
  $scope.deleteTask = function (task) {
    if(confirm("Are you sure to delete this line?")){

      console.log(task)
      var req = {
        method: 'POST',
        url: 'php/main.php',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8',
          'X-API-KEY' : 'ac54bcf346e578feb46888b3ecd2344f'
        },
        data: { type: 'delete', taskId: task }
      }


    $http(req).then(function(data){
        getTask();
      });
    }
  };

  // toggelStatus method for updating tasks
  $scope.toggleStatus = function(item, status, task) {

    var taskSet = false;
    if(status=='2'){status='0';}else{status='2';}

    // set request parameters      
    var req = {
      method: 'POST',
      url: 'php/main.php',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8',
        'X-API-KEY' : 'ac54bcf346e578feb46888b3ecd2344f'
      },
      data: { type: 'update', status: status, taskId: item }
    }
    
    $http(req).then(function(data) {
      getTask();
    });

     // check if an item was selected or not
     $scope.isAllSelected = $scope.tasks.every(function(itm){ return itm.selected; });

  };

    // SELECT ALL || UNSELECT ALL
  $scope.toggleAll = function() {
     var toggleStatus = $scope.isAllSelected;
     
     angular.forEach($scope.tasks, function(itm){ 

       //console.log(itm);
       itm.selected = toggleStatus; 

       if(itm.STATUS!=='2' && itm.selected == true)
       {
         itm.STATUS='2';

         // set request parameters      
          var req = {
            method: 'POST',
            url: 'php/main.php',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8',
              'X-API-KEY' : 'ac54bcf346e578feb46888b3ecd2344f'
            },
            data: { type: 'update', status: itm.STATUS, taskId: itm.ID }
          }

         // UPDATE all SELECTED
         $http(req).then(function(data){
          getTask();
         });
       }
       else if(itm.selected == false)
       {
         itm.STATUS='0';

         // set request parameters      
          var req = {
            method: 'POST',
            url: 'php/main.php',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8',
              'X-API-KEY' : 'ac54bcf346e578feb46888b3ecd2344f'
            },
            data: { type: 'update', status: itm.STATUS, taskId: itm.ID }
          }
         // UPDATE all SELECTED
         $http(req).then(function(data){
          getTask();
         });
        
       }
        
      });
  };

});
