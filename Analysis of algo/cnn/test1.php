<html>

<head>
  <meta charset="UTF-8">
  <title>CNN</title>


	<!--<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs-vis"></script>-->
<style>
	table{
		border-collapse: collapse;
	}
</style>
</head>

<body>
<a href="index.php" style="padding:8px;color:white;font-weight:bold;background-color:lightgreen;text-decoration:none">Go To Training</a>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.1.9/p5.js"></script>
<script src="https://unpkg.com/ml5@0.6.0/dist/ml5.min.js"></script>	
<!--<script src="test.js"></script>-->
<?php
$dir = "testing/";
$a = scandir($dir);

foreach($a as $file){
	if($file!='.' && $file!='..'){
		$i=0;
	foreach(glob($dir.$file.'/'.'*.*',GLOB_BRACE) as $fileimg){
      $imag[] =  $dir.$file.'/'.basename($fileimg);
	 echo "<script>localStorage.setItem('".$file.'-'.$i++."', '".$fileimg."');</script>";
	}
	}
}

?>
<br>
<svg width="90" height="29">
  <rect x="50" y="20" width="20" height="10" style="fill:rgb(0,255,0);stroke:rgb(0,255,0);stroke-width:5;" />
  Sorry, your browser does not support inline SVG.  
</svg> Predicted Values<br>
<svg width="90" height="29">
  <rect x="50" y="20" width="20" height="10" style="fill:blue;stroke:blue;stroke-width:5;" />
  Sorry, your browser does not support inline SVG.  
</svg> Actual Values<br><br>
<script>
//var x=Object.keys(localStorage);


 
	//predict from existing module using tensorflow
//	console.log(positive);
	
var classifier;
var canvas;

var inputImage;
var inputImage1;
var clearButton;
var video=[];
var modelready;
var negative=[];
 var localstoragelength = 20;//localStorage.length;
 ///console.log(localstoragelength);
 var totalnumberofimg;
 var totalcorrectpred;

var count=0;
function setup() {	  
		canvas = createCanvas(2000, 400);
		
		for (let i = 0; i < localstoragelength; i++) {
	   var positives=localStorage.getItem("cat-"+i);
	   
	   if(positives!==null){
     let index = nf(i + 1, 4, 0);
	 let lbl1=localStorage.getItem("lbl1");
	 let lbl2=localStorage.getItem("lbl2");
	
     video[i] = loadImage(`testing/`+lbl1+`/`+lbl1+`-${index}.jpg`);
     negative[i] = loadImage(`testing/`+lbl2+`/`+lbl2+`-${index}.jpg`);
	// totalnumberofimg
	count++;
	  
	
	   }
   }
var ttlimg= createDiv("Total number of Test images: "+count*2);
ttlimg.style('padding', '20px');
ttlimg.id("ttlimg");
//totalcorrectpred
var ttlcprdimg= createDiv();
ttlcprdimg.style('padding', '20px');
ttlcprdimg.id("ttlcprdimg");

var ttlwprdimg= createDiv();
ttlwprdimg.style('padding', '20px');
ttlwprdimg.id("ttlwprdimg");

var ttlcwprdimg= createDiv();
ttlcwprdimg.style('padding', '20px');
ttlcwprdimg.id("ttlcwprdimg");


var fp=createDiv();
fp.style('padding', '20px');
fp.id("fp");

var fn=createDiv();
 fn.style('padding', '20px');
fn.id("fn");

 var accuracy=createDiv();
 accuracy.style('padding', '20px');
accuracy.id("accuracy");

var precision=createDiv();
precision.style('padding', '20px');
precision.id("precision");


var recall=createDiv();
recall.style('padding', '20px');
recall.id("recall");

var fonescore=createDiv();
fonescore.style('padding', '20px');
fonescore.id("fonescore");

var specificity=createDiv();
specificity.style('padding', '20px');
specificity.id("specificity");

/////////////////////////////// start of table
var tbl = document.createElement("TABLE");
    tbl.setAttribute("id", "cofusionmatrix");
    tbl.setAttribute("style", "width:70%;margin-left:150px;");
    document.body.appendChild(tbl);
  
    var tbltrr = document.createElement("TR");
    tbltrr.setAttribute("id", "tbltrr");
    document.getElementById("cofusionmatrix").appendChild(tbltrr);
	
	var td11 = document.createElement("TH");
    var tdcell11 = document.createTextNode("Actual Values");
	td11.setAttribute("colspan", "4");
	td11.setAttribute("style", "padding-left:120px;");
	td11.appendChild(tdcell11);
	document.getElementById("tbltrr").appendChild(td11);
    
    var tbltr = document.createElement("TR");
    tbltr.setAttribute("id", "tbltr");
    document.getElementById("cofusionmatrix").appendChild(tbltr);
  
	var td3 = document.createElement("TH");
    var tdcell3 = document.createTextNode("");
	td3.appendChild(tdcell3);
	//td3.setAttribute("rowspan", "3");
	document.getElementById("tbltr").appendChild(td3);
  
  	var td4 = document.createElement("TH");
    var tdcell4 = document.createTextNode("");
	td4.appendChild(tdcell4);
	document.getElementById("tbltr").appendChild(td4);
	
    var td1 = document.createElement("TH");
    var tdcell1 = document.createTextNode("Positive");
	td1.appendChild(tdcell1);
	document.getElementById("tbltr").appendChild(td1);
  
    var td2 = document.createElement("TH");
    var tdcell2 = document.createTextNode("Negative");
	td2.appendChild(tdcell2);
	document.getElementById("tbltr").appendChild(td2);
	
	//////
	var tbltr = document.createElement("TR");
    tbltr.setAttribute("id", "tbltrd");
    document.getElementById("cofusionmatrix").appendChild(tbltr);
  
	var td3 = document.createElement("TH");
    var tdcell3 = document.createTextNode("Predicted Values");
	td3.appendChild(tdcell3);
	td3.setAttribute("style", "padding-top:170px;");
	document.getElementById("tbltrd").appendChild(td3);
  
  	var td4 = document.createElement("TH");
    var tdcell4 = document.createTextNode("Positive");
	td4.appendChild(tdcell4);
	document.getElementById("tbltrd").appendChild(td4);
	
    var td1 = document.createElement("TH");
    var tdcell1 = document.createTextNode("TP=");
	td1.appendChild(tdcell1);
	td1.setAttribute("id", "Tpss");
	td1.setAttribute("style", "border: 1px solid black;width:400px;height:200px");
	document.getElementById("tbltrd").appendChild(td1);
  
    var td2 = document.createElement("TH");
    var tdcell2 = document.createTextNode("FP=");
	td2.setAttribute("id", "Fpss");
	td2.appendChild(tdcell2);
	td2.setAttribute("style", "border: 1px solid black;width:400px;height:200px");
	document.getElementById("tbltrd").appendChild(td2);


    var tbltr = document.createElement("TR");
    tbltr.setAttribute("id", "tbltrdd");
    document.getElementById("cofusionmatrix").appendChild(tbltr);
  
	var td3 = document.createElement("TH");
    var tdcell3 = document.createTextNode("");
	td3.appendChild(tdcell3);
	//td3.setAttribute("rowspan", "3");
	document.getElementById("tbltrdd").appendChild(td3);
  
  	var td4 = document.createElement("TH");
    var tdcell4 = document.createTextNode("Negative");
	td4.appendChild(tdcell4);
	document.getElementById("tbltrdd").appendChild(td4);
	
    var td1 = document.createElement("TH");
    var tdcell1 = document.createTextNode("FN=");
	td1.setAttribute("id", "Fnss");
	td1.appendChild(tdcell1);
	td1.setAttribute("style", "border: 1px solid black;width:400px;height:200px");
	
	document.getElementById("tbltrdd").appendChild(td1);
  
    var td2 = document.createElement("TH");
    var tdcell2 = document.createTextNode("TN=");
	td2.setAttribute("id","Tnss");
	td2.appendChild(tdcell2);
	td2.setAttribute("style", "border: 1px solid black;width:400px;height:200px");
	document.getElementById("tbltrdd").appendChild(td2);
/////////////end of table

background(255);
	
  var options = {
    inputs: [64, 64, 4],
    task: 'imageClassification',
  };
  classifier = ml5.neuralNetwork(options);
  const modelDetails = {
    model: 'model.json',
    metadata: 'model_meta.json',
    weights: 'model.weights.bin',
  };

  classifier.load(modelDetails, modelLoaded);
function modelLoaded() {
  console.log('model ready!');
  classifyImage();
 modelready="model ready";
}

}


function classifyImage() {
	
for (let i = 0; i < localstoragelength; i++) {	
 var positives=localStorage.getItem("cat-"+i);
	   if(positives!==null){
  classifier.classify(
    {
      image: video[i]
	  
    },
    gotResults
  );
  classifier.classify(
    {
      image: negative[i]
	  
    },
    gotResultss
  );
}
}
}
var labelx=[];

 for (let i = 0; i < localstoragelength; i++) {	
 var positives=localStorage.getItem("cat-"+i);
	   if(positives!==null){
	labelx[i]="label"+i;
  }}
  var k=0;
   
function gotResults(err, results) {
  if (err) {
    console.error(err);
    return;
  }

  labelx[k] = results[0].label + " " + nf(100 * results[0].confidence, 2, 0)+"%";
  console.log(labelx[k]);
  
	k++;
	

}
//console.log(countlblp);
var labely=[];
 for (let i = 0; i < localstoragelength; i++) {	
 var positives=localStorage.getItem("cat-"+i);
	   if(positives!==null){
	labely[i]="labels"+i;
  }}
  var m=0;
function gotResultss(err, results) {
  if (err) {
    console.error(err);
    return;
  }
  labely[m] = results[0].label + " " + nf(100 * results[0].confidence, 2, 0)+"%";
  console.log(labely[m]);
	m++;

}


function draw() {
background(220);
let j;
var x;
for ( j = 0; j < localstoragelength; j++) {	
 var positives=localStorage.getItem("cat-"+j);
	   if(positives!==null && modelready=="model ready"){
		    x=80*j;
		   
		image(video[j], x, 80, 64, 64);
		image(negative[j], x, 230, 64, 64);
	
}}

		noStroke();
		fill('rgb(0,255,0)');
		rect(0,0,width, 35);
		fill(0);
		var countlblp=0;
		var fp=0;
		for ( var k = 0; k < localstoragelength; k++) {	
 var positives=localStorage.getItem("cat-"+k);
	   if(positives!==null && modelready=="model ready"){
		  var z=80*k;
		  var res = labelx[k].split(" ");
		   if(res[0]==="cat"){
				countlblp++;
				
			}
			if(res[0]==="dog"){
				fp++;
				
			}
		text(labelx[k], z, 20);
		}}
	
		
		document.getElementById("ttlcprdimg").innerHTML="Total Number of Correct Prediction Positive(TP): "+countlblp;
		
		document.getElementById("Tpss").innerHTML="TP="+countlblp;
		
		document.getElementById("fp").innerHTML="Total Number of Wrong Prediction Positive(FP): "+fp;
		
		document.getElementById("Fpss").innerHTML="FP="+fp;
		
		noStroke();
		fill('rgb(0,255,0)');
		rect(0,150,width, 35);
		fill(0);
		 var countlbln=0;
		 var countfn=0;
		for ( var z = 0; z < localstoragelength; z++) {	
		var positives=localStorage.getItem("dog-"+z);
		if(positives!==null && modelready=="model ready"){
		  var p=80*z;
		  var res = labely[z].split(" ");
		   if(res[0]==="dog"){
				countlbln++;
			}
		 if(res[0]==="cat"){
				countfn++;
			}
		 
		text(labely[z], p, 170);

		}}
		document.getElementById("ttlwprdimg").innerHTML="Total Number of Correct Prediction Negative(TN): "+countlbln;
		
		
		document.getElementById("Tnss").innerHTML="TN="+countlbln;
		
		document.getElementById("fn").innerHTML="Total Number of Wrong Prediction Negative(FN): "+countfn;
		
		document.getElementById("Fnss").innerHTML="FN="+countfn;
		
		noStroke();
		fill(color(0, 0, 255));
		rect(0,35,width, 35);
		fill(255);

		
		document.getElementById("ttlcwprdimg").innerHTML="Total Number of Correct Prediction True Positive and True Negative: "+(countlbln+countlblp);
		
		document.getElementById("accuracy").innerHTML="Accuracy: "+(countlbln+countlblp)/(countlbln+countlblp+fp+countfn)*100;
		//(countlbln+countlblp)*100/(count*2);
		//(countlbln+countlblp)/(countlbln+countlblp+fp+countfn);
		
		
		document.getElementById("specificity").innerHTML="Precision: "+(countlblp/(countlblp+fp));
		var prec=(countlblp/(countlblp+fp));
		
		document.getElementById("recall").innerHTML="Recall: "+(countlblp/(countlblp+countfn));
		var recl=(countlblp/(countlblp+countfn));
		
		document.getElementById("fonescore").innerHTML="f1 score: "+(2*(prec*recl)/(prec+recl));
		
		
		document.getElementById("specificity").innerHTML="Specificity: "+(countlbln/(countlbln+fp));
		
		//specificity=(True Negative)/(True Negative + False Positive)
		
			for ( var k = 0; k < localstoragelength; k++) {	
 var positives=localStorage.getItem("cat-"+k);
	   if(positives!==null && modelready=="model ready"){
		  var z=80*k;
		   
		text("cat", z, 60);
		
		
		}}
		noStroke();
		fill(color(0, 0, 255));
		rect(0,185,width, 35);
		fill(255);
for ( var z = 0; z < localstoragelength; z++) {	
		var positives=localStorage.getItem("dog-"+z);
		if(positives!==null && modelready=="model ready"){
		  var p=80*z;
		   
		text("dog", p, 210);
		}}
}

</script>

</body>

</html>