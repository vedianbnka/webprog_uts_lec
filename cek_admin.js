function checkSession() {
    // Kirim permintaan AJAX ke check_session.php
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../check_session_admin.php", true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.status === "inactive") {
          window.location.href = "../login/index.php";
        }Z
      }
    };
    xhr.send();
  }
  
  setInterval(checkSession, 1);