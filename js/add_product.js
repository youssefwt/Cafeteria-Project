let inputProduct = document.getElementById("inputProduct");
let labelProduct=document.getElementById("labelProduct");
let submit=document.getElementById("submit");
let isValidName=false;
let isValidImg=false;
inputProduct.addEventListener("keyup",validatName )
function validatName(){
    let ProductTestName =  inputProduct.value.search(/^[A-Za-z]+$/);
    if (ProductTestName == -1|| inputProduct == ""){
    labelProduct.innerHTML="Please enter only letters in this field.";
  
    isValidName=false;
    }
    else{
        labelProduct.innerHTML="";
        isValidName=true;
    }

}
let inputPicture=document.getElementById("inputPicture");
let labelImg=document.getElementById("labelImg");
inputPicture.addEventListener("change",validatImg)
function validatImg(){
    let isValid= (/\.(gif|jpe?g|tiff?|png|webp|bmp)$/i).test(inputPicture.value)
     if(!isValid){
         labelImg.innerHTML="only jpg or png or gif files allowed!";
         isValidImg=false;
     }
     else{
         labelImg.innerHTML="";
         isValidImg=true;
     }}
submit.addEventListener("click",function(e){
    if(!(isValidImg || isValidName)){
     e.preventDefault();
     validatImg();
     validatName();

    }
})


