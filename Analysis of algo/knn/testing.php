<html>

<head>
  <meta charset="UTF-8">
  <title>KNN</title>

<script src="https://cdn.jsdelivr.net/npm/p5@1.4.1/lib/p5.min.js"></script>
    <script src="https://unpkg.com/ml5@0.4.3/dist/ml5.min.js"></script>
   
	  <script src="test.js"></script>
<style>
#greenpred{
display:inline-block;
height:15px;
width:25px;	
background-color:green;
	
}
#blueact{
display:inline-block;
height:15px;
width:25px;	
background-color:blue;
	
}

#catimg{

		width:2800px;
}
#dogimg{
	
		width:2800px;
}
img{
		margin-right:10px;
}
#imgp{
		display:inline-block;
		width:60px;
		text-align:center;
		margin-right:10px;
}
#pcat{
		background-color:green;
		width:2800px;
		
}
#pdog{
		background-color:green;
		width:2800px;
		
}
#acat{
		background-color:blue;
		width:2800px;
		color:white;
} 
#adog{
		background-color:blue;
		width:2800px;
		color:white;
}
</style>
</head>



<body>
<a href="index.php" style="padding:8px;color:white;font-weight:bold;background-color:lightgreen;text-decoration:none">Go Trining Module</a>
<br><br><div id="greenpred"></div> Predicted<br><br>
<div id="blueact"></div> Actual
<div id="sec">
<p id="acat"></p>
<p id="pcat"></p>
<p id="catimg"></p>
<p id="adog"></p>
<p id="pdog"></p>
<p id="dogimg"></p>
</div>

<div>
<table border="1" cellspacing="0" cellpadding="20" style="text-align:center">
	<tr>
		<td colspan="4">Actual</td>
		
	</tr>
		<tr>
		<td rowspan="4">Predicted</td>
		<td></td>
		<td>Cat</td>
		<td>Dog</td>
	</tr>
		<tr >
		
		<td>Cat</td>
		<td><span id="tp"></span>(TP)</td>
		<td><span id="fp"></span>(FP)</td>
	</tr>
		<tr >
		
		<td>Dog</td>
		<td><span id="fn"></span>(FN)</td>
		<td><span id="tn"></span>(TN)</td>
	</tr>
</table>
</div>
<div>
<p> Accuracy (all correct / all) = TP + TN / TP + TN + FP + FN =  </p> <span id="accuracy"></span>
<p> Misclassification (all incorrect / all) = FP + FN / TP + TN + FP + FN =  </p> <span id="misclassification"></span>
<p> Precision (true positives / predicted positives) = TP / TP + FP =  </p> <span id="precision"></span>
<p> Sensitivity aka Recall (true positives / all actual positives) = TP / TP + FN =  </p> <span id="sensitivity"></span>
<p> Specificity (true negatives / all actual negatives) =TN / TN + FP =  </p> <span id="specificity"></span>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
</body>

</html>