
let positive = [];
let negative = [];
//let tigers = [];

function preload() {
  for (let i = 0; i < 271; i++) {
    let index = nf(i + 1, 4, 0);
	let lbl1=localStorage.getItem("lbl1");
	let lbl2=localStorage.getItem("lbl2");
	
    positive[i] = loadImage(`images/`+lbl1+`/`+lbl1+`-${index}.jpg`);
    negative[i] = loadImage(`images/`+lbl2+`/`+lbl2+`-${index}.jpg`);
   // tigers[i] = loadImage(`images/tiger/tiger${index}.jpg`);
  }
}

let imgClassifier;//shapeClassifier

function setup() {
  createCanvas(400, 400);
  let customlayers = [
    {
      type: 'conv2d',
      filters: 8,
      kernelSize: 5,
      strides: 1,
      activation: 'relu',
      kernelInitializer: 'varianceScaling',
    },
    {
      type: 'maxPooling2d',
      poolSize: [2, 2],
      strides: [2, 2],
    },
	{
      type: 'conv2d',
      filters: 8,
      kernelSize: 5,
      strides: 1,
      activation: 'relu',
      kernelInitializer: 'varianceScaling',
    },
    {
      type: 'maxPooling2d',
      poolSize: [2, 2],
      strides: [2, 2],
    },
	{
      type: 'conv2d',
      filters: 8,
      kernelSize: 5,
      strides: 1,
      activation: 'relu',
      kernelInitializer: 'varianceScaling',
    },
    {
      type: 'maxPooling2d',
      poolSize: [2, 2],
      strides: [2, 2],
    },
    {
      type: 'flatten',
    },
    {
      type: 'dense',
      kernelInitializer: 'varianceScaling',
      activation: 'softmax',
    },
  ];

  let options = {
    inputs: [64, 64, 4],
    task: 'imageClassification',
    layers: customlayers,
    debug: true
  };
  imgClassifier = ml5.neuralNetwork(options);

  for (let i = 0; i < positive.length; i++) {
    imgClassifier.addData({ image: positive[i] }, { label: 'cat' });
    imgClassifier.addData({ image: negative[i] }, { label: 'dog' });	
  }
  imgClassifier.normalizeData();
  imgClassifier.train({ epochs: 200 }, finishedTraining);
 
}

function finishedTraining() {
  console.log('finished training!');
   console.log(imgClassifier);
  imgClassifier.save();
}

