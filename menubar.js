document.getElementById("myBtn").addEventListener("click", open_close);

var menuState = 1 // close
function open_close() {
   if(menuState === 0){
    menuState = 1;
    document.getElementById("mySidenav").style.width = "250px";
   }
   else {
    menuState = 0;
    document.getElementById("mySidenav").style.width = "0";
   }
   console.log(menuState);
} 