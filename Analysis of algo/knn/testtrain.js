

let video;
let features;
let knn;
let labelP;
let ready = false;
let x;
let y;
let label = 'nothing';
let positive = [];
let negative = [];
let positive1 = [];
let negative1 = [];

let lbl1;
let lbl2;
function setup() {
	 
   
for (let i = 0; i < 979; i++) {
    let index = nf(i + 1, 4, 0);
	 lbl1=localStorage.getItem("lbl1");
	 lbl2=localStorage.getItem("lbl2");
	createCanvas(64,64);
     positive[i] = createImg(`images/`+lbl1+`/`+lbl1+`-${index}.jpg`);
     negative[i] = createImg(`images/`+lbl2+`/`+lbl2+`-${index}.jpg`);
 
  
  }
  
  features = ml5.featureExtractor('MobileNet', modelReady);
  knn = ml5.KNNClassifier();
  
 
}

function keyPressed() {
	if (key == 't') {		
	  for (let i = 0; i < 979; i++) {
		//console.log(positive[i]);
	    positive1[i] = features.infer(positive[i]);
	    negative1[i] = features.infer(negative[i]);
    
	   knn.addExample(positive1[i], lbl1);
	   knn.addExample(negative1[i], lbl2);
	   console.log("training..");
	 }
   console.log("training complete");
  }
	
 
 if (key == 's') {
    save(knn, 'model.json');
    //knn.save('model.json');
  }
}

function modelReady() {
  console.log('model ready!');
 
}

function draw() {
 
}

// Temporary save code until ml5 version 0.2.2
const save = (knn, name) => {
  const dataset = knn.knnClassifier.getClassifierDataset();
  if (knn.mapStringToIndex.length > 0) {
    Object.keys(dataset).forEach(key => {
      if (knn.mapStringToIndex[key]) {
        dataset[key].label = knn.mapStringToIndex[key];
      }
    });
  }
  const tensors = Object.keys(dataset).map(key => {
    const t = dataset[key];
    if (t) {
      return t.dataSync();
    }
    return null;
  });
  let fileName = 'myKNN.json';
  if (name) {
    fileName = name.endsWith('.json') ? name : `${name}.json`;
  }
  saveFile(fileName, JSON.stringify({ dataset, tensors }));
};

const saveFile = (name, data) => {
  const downloadElt = document.createElement('a');
  const blob = new Blob([data], { type: 'octet/stream' });
  const url = URL.createObjectURL(blob);
  downloadElt.setAttribute('href', url);
  downloadElt.setAttribute('download', name);
  downloadElt.style.display = 'none';
  document.body.appendChild(downloadElt);
  downloadElt.click();
  document.body.removeChild(downloadElt);
  URL.revokeObjectURL(url);
};