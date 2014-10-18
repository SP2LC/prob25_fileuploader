function Change1(){
   radio = document.getElementsByName('proposal');
   if(radio[0].checked){
      document.getElementById('firstBox').style.display = "";
      document.getElementById('firstBox2').style.display = "";
      document.getElementById('secondBox').style.display = "none";
   }
   else if(radio[1].checked){
      document.getElementById('firstBox').style.display = "none";
      document.getElementById('firstBox2').style.display = "none";
      document.getElementById('secondBox').style.display = "";
   }
}
