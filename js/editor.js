var editMode = false;

function swapEdit(){
    const textItems = document.querySelectorAll("[id$=text]");
    const inputItems = document.querySelectorAll("[id$=input]");
    x = textItems.length;
    y = inputItems.length;
    console.log(inputItems);
    console.log(textItems);
    let stat2 = document.getElementById('2statChecker');
    if(editMode){
        for(let i = 0;i<x;i++){//using let i in list causes loop to overshoot
            textItems[i].removeAttribute('hidden');
        }
        for(let i = 0;i<y;i++){
            inputItems[i].setAttribute('hidden','true');
        }
        stat2.setAttribute('hidden','true');
    }else{
        for(let i = 0;i<x;i++){
            textItems[i].setAttribute('hidden','true');
        }
        for(let i = 0;i<y;i++){
            inputItems[i].removeAttribute('hidden');
        }
        stat2.removeAttribute('hidden');
    }
    editMode = !editMode;
}