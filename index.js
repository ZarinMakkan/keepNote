// function toChangeTick(id) {
//     var status = 'todo';
//     if ($("#task_" + id).prop('checked') == true) {
//         status = 'done';
//     }
//     $.ajax({
//         type: "POST",
//         url: window.location.href,
//         data: {
//             status: status,
//             task_id: id
//         }, // serializes the form's elements.
//         success: function (data) {
//             location.reload();
//         }
//     });
// }
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
// //about collaborate modal
// var collabmodal = document.getElementById("modalco");
// var collabBtns = document.getElementsByClassName("btnOpenCollabModal");
// var closeCollabModal = document.getElementById("closeSubmitmodal");
// var taskcollabID;

// for (let i = 0; i < collabBtns.length; i++) {
//     collabBtns[i].onclick = function () {
//         collabmodal.style.display = "block";
//         taskcollabID = collabBtns[i].getAttribute('id');
//     }
// }

// closeCollabModal.onclick = function () {
//     var taskCID = document.getElementById("taskCID");
//     taskCID.value = taskcollabID;
//     collabmodal.style.display = "none";
// }

// window.onclick = function (event) {
//     if (event.target == collabmodal) {
//         collabmodal.style.display = "none";
//     }
// }

function modalAccountOption() {
  var accountmodal = document.getElementById("accountModal");

  accountmodal.style.display = "block";

  window.onclick = function (event) {
    if (event.target == accountmodal) {
      accountmodal.style.display = "none";
    }
  }

}