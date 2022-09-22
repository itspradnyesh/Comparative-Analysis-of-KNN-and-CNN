let video;
let features;
let knn;
let labelP;
let ready = false;
let x;
let y;
//let label = 'nothing';
let positive = [];
let negative = [];
let positive1 = [];
let negative1 = [];
let lbl1;
let lbl2;

function setup() {
  	 
   
for (let i = 0; i <= 19; i++) {
    let index = nf(i + 1, 4, 0);
	 lbl1=localStorage.getItem("lbl1");
	 lbl2=localStorage.getItem("lbl2");
	 var myCanvas=createCanvas(64,64);
     
	
	//document.getElementById("catimg").innerHTML= positive[i] = createImg(`testing/`+lbl1+`/`+lbl1+`-${index}.jpg`); 
    positive[i] = createImg(`testing/`+lbl1+`/`+lbl1+`-${index}.jpg`);
	 positive[i].parent('catimg');
	negative[i] = createImg(`testing/`+lbl2+`/`+lbl2+`-${index}.jpg`);
	 negative[i].parent('dogimg');
	
  }
  
  features = ml5.featureExtractor('MobileNet', modelReady);
  knn = ml5.KNNClassifier();
}
 
function goClassify() {
  var counttp=1;
  var countfn=1;
  
  //var counttpp;
  for (let i = 0; i <= 19; i++) {
	 	
	   positive1[i] = features.infer(positive[i]);
    
	   console.log("Clasifying cat..");
	  
  
			  knn.classify(positive1[i], function(error, result) {
				if (error) {
				  console.error(error);
				} else {
				   label22 = result.label;
				   lbl11="";
				  				   
				   if(label22=="0"){
					 lbl11="<span id='imgp'>cat</span>";
				
					  document.getElementById("tp").innerHTML=parseInt(counttp); 
					  
					  var tpc=$('#tp').text();
					localStorage.setItem("tp",tpc);
					  counttp++;
					 
				   }else if(label22=="1"){
					 lbl11="<span id='imgp'>dog</span>";
					 document.getElementById("fn").innerHTML=parseInt(countfn); 
					 var fnc=$('#fn').text();
					localStorage.setItem("fn",fnc);
					  countfn++;
					 
				   }
				$("#pcat").append(lbl11+" ");   
				$("#acat").append("<span id='imgp'>cat</span>"+" ");  
	
				}
			  });
			  
			 

  }
 

console.log("cat Clasification Complete!!");
  
}

function goClassify1(){
	var counttn=1;
	var countfp=1;
	for(j=0;j<=19;j++){
	  	//positive1[j] = features.infer(positive[j]);
	    negative1[j] = features.infer(negative[j]);
	  console.log("Clasifying dog..");
	   knn.classify(negative1[j], function(error, result) {
				if (error) {
				  console.error(error);
				} else {
				   label1 = result.label;
				  // console.log(result.label);
				   lbl22="";
				   if(label1=="0"){
					 lbl22="<span id='imgp'>cat</span>";
					 document.getElementById("fp").innerHTML=parseInt(countfp); 
					 var fpc=$('#fp').text();
					localStorage.setItem("fp",fpc);
					  countfp++;
					 
				   }else if(label1=="1"){
					 lbl22="<span id='imgp'>dog</span>";
					 document.getElementById("tn").innerHTML=parseInt(counttn); 
					 var tnc=$('#tn').text();
					localStorage.setItem("tn",tnc);
					  counttn++;
				   }
				 
			//console.log(lbl22);  
			$("#pdog").append(lbl22+" "); 
			$("#adog").append("<span id='imgp'>dog</span>"+" "); 
		  
				//  goClassify1();
				   
				}
			  });
  }
	 console.log("dog Clasification Complete!!");
	 
	 	
 var tpcc=localStorage.getItem("tp");
 var tpc=parseInt(tpcc);
 var tncc=localStorage.getItem("tn");
 var tnc=parseInt(tncc);
 var fpcc=localStorage.getItem("fp");
 var fpc=parseInt(fpcc);
 var fncc=localStorage.getItem("fn");
 var fnc=parseInt(fncc);

 var accuracy=(tpc + tnc) / (tpc + tnc + fpc + fnc);

 var misclassification=(fpc + fnc) / (tpc + tnc + fpc + fnc);

 var precision= tpc / (tpc + fpc);

 var sensitivity= tpc / (tpc + fnc);

 var specificity= tnc / (tnc + fpc);

 document.getElementById("accuracy").innerHTML=accuracy;
 document.getElementById("misclassification").innerHTML=misclassification;
 document.getElementById("precision").innerHTML=precision;
 document.getElementById("sensitivity").innerHTML=sensitivity;
 document.getElementById("specificity").innerHTML=specificity;

}

function modelReady() {
  console.log('model ready!');
  // Comment back in to load your own model!
   knn.load('model.json', function() {
     console.log('knn loaded');
	 
   });
}

function draw() {
 

  //image(video, 0, 0);
  if (!ready && knn.getNumLabels() > 0) {
    goClassify();
    goClassify1();
    ready = true;
  }
}

