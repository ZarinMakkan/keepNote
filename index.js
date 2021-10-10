function toChangeTick(id) {
    var status = 'todo';
    if ($("#task_" + id).prop('checked') == true) {
        status = 'done';
    }
    $.ajax({
        type: "POST",
        url: window.location.href,
        data: {
            status: status,
            task_id: id
        }, // serializes the form's elements.
        success: function (data) {
            location.reload();
        }
    });
}

function logout() {
    $.ajax({
        type: "POST",
        url: window.location.href,
        data: {
            logout: 'yes'
        },
        success: function () {
            location.reload();
        }
    });

}
//about collaborate modal
var modal = document.getElementById("modal");
var collabBtns = document.getElementsByClassName("btnOpenCollabModal");
var closeModal = document.getElementById("closeSubmitmodal");
var taskID;

for (let i = 0; i < collabBtns.length; i++) {
    collabBtns[i].onclick = function () {
        modal.style.display = "block";
        taskID = collabBtns[i].getAttribute('id');
    }
}

closeModal.onclick = function () {
    var taskCID = document.getElementById("taskCID");
    taskCID.value = taskID;
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
////////////////////////////
