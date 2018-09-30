
		var canvas=document.getElementById("canvas");
		var can=canvas.getContext("2d");
		var s=window.screen;
		var w=canvas.width=s.width;
		var h=canvas.height=s.height;

		can.fillStyle=color2();

		var words = Array(256).join("1").split("");

		setInterval(draw,50);

		function draw(){
			can.fillStyle='rgba(0,0,0,0.05)';
			can.fillRect(0,0,w,h);
			can.fillStyle=color2();
			words.map(function(y,n){
				text=String.fromCharCode(Math.ceil(65+Math.random()*57)); 
				x = n*10;
				can.fillText(text,x,y)
				words[n]=( y > 758 + Math.random()*484 ? 0:y+10 );
			});
		}

		function color1(){
			var colors=[0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f'];
			var color="";
			for( var i=0; i<6; i++){
				var n=Math.ceil(Math.random()*15);
				color += "" + colors[n];
			}
			return '#'+color;
		}

		function color2(){
			var color = Math.ceil(Math.random()*16777215).toString(16); 
			while(color.length<6){
				color = '0'+color;
			}
			return '#'+color;
		}
		function color3(){
			return "#" + (function(color){
				return new Array(7-color.length).join("0")+color;
			})((Math.random()*0x1000000 << 0).toString(16))
		}
