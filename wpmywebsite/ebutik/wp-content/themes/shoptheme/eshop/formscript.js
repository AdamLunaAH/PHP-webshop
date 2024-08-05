// Javascript show password toggle
function pswShow(pswButton){
    
  if(pswButton.classList.contains("fa-eye")){
    pswButton.classList.remove("fa-eye");
    pswButton.classList.add("fa-eye-slash")
  }else{
    pswButton.classList.remove("fa-eye-slash");
    pswButton.classList.add("fa-eye");}

  var x = document.getElementById("psw");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
  var x = document.getElementById("reppsw");
  if (x != null){
    var x = document.getElementById("reppsw");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }}};