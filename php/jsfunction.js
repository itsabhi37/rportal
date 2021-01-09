// JavaScript Document

/*Delete Particular row, Function with Id and tablename parameter*/
function myFunction(id,tab) {
    var x;
    if (confirm("Do You Want To Delete?") == true) {
		 window.location.href = 'delete.php?id='+id+'&table='+tab;
    } else {
       alert('Deletion Cancel!');
    }
}