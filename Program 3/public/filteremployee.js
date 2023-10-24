function filterEmployeeByProject() {
    //get the id of the selected project from the filter dropdown
    var project_id = document.getElementById('project_filter').value
    //construct the URL and redirect to it
    window.location = '/employee/filter/' + parseInt(project_id)
}