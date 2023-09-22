(function() {
	// in function because of conflict with global attributtes of Internetgalerie scripts

	var $ = function(id) { return document.getElementById(id) };
	var canvas = new fabric.Canvas('canvasshow', {
		allowTouchScrolling: true,
	});
	ctx = canvas.getContext('2d');
	var scales = [];
	// Drawing status 0 = free, 1 = Route started, 2 = Check if selectable available , 3 = Route finished
	var editStatus = 0;

	// distinguish between Edit  and Show
	if(jQuery('#mode').attr('mode') == "edit") {
		// User controls
		var remove = $('remove'),
			fluid = $('fluid'),
			addPoint = $('addPoint'),
			startRoute = $('startRoute'),
			endRoute = $('endRoute'),
			checkend = jQuery('#checkend').attr('value');
		// Remove the Route being draw
		remove.onclick = removeObjects;
		//
		fluid.onclick = getObjects;
		startRoute.onclick = addRoute;
		addPoint.onclick = addP;
		endRoute.onclick = addEndpoint;
		// remove the line of the deleted route
		jQuery('#confirmButton').on("click", function() {

			if (confirm("You Sure?")) {
				removeObjects();
				groupObjects();
				jQuery('#fluidSendDeleted').attr('value', JSON.stringify(canvas));
				console.log('SUCESS');
				jQuery('#fluidDelete').click();
			}

		});
		canvas.allowTouchScrolling = false;
	} else {
		window.addEventListener("load", function() {
			jQuery('#canvasshow').css('pointer-events', 'none');
			jQuery('.upper-canvas').css('pointer-events', 'none');
			jQuery('#canvasshow').css('touch-action', 'manipulation');
		});

		canvas.selection = false;
		canvas.allowTouchScrolling = true;
		console.log('here is read only...');
	}


	// Size of the saved canvas to resize the objects to the actual size of the canvas
	var drawScales = [];
	// verify if ID double
	var verifyInput = [];
	// the factor for drawing
	var drawFactor;

	/*
	* initialize canvas
	* Code 82 & 140 help from: https://stackoverflow.com/questions/3971841/how-to-resize-images-proportionally-keeping-the-aspect-ratio
	* canvas.renderAll() problem with update: https://stackoverflow.com/questions/16694075/why-doesnt-fabricjs-canvas-update-properly-after-object-center/16694541
	*/
	function initialize() {

		// get original size of image
		if(jQuery("#image").attr("src") && jQuery("#image").attr("src") !== '') {
			var myImg = document.querySelector("#image");
			drawScales[0] = myImg.naturalWidth;
			drawScales[1] = myImg.naturalHeight;
		}
		/*
	    set height of canvas as height of image if no canvas loaded
	    else load the saved canvas from the Model
	    */
		if(jQuery('#loadcanvas').attr('data-canvas') == "") {
			scales[0] = drawScales[0];
			scales[1] = drawScales[1];
			drawFactor = 1;

		} else {
			drawFactor = 1;
			canvas.loadFromJSON(jQuery('#loadcanvas').attr('data-canvas'));
		}
		if(jQuery('#image').width() !== "") {
			canvas.setWidth(jQuery('#image').width());
			canvas.setHeight(jQuery('#image').height());
		}

		var loadfactor = Math.min(canvas.getWidth() / drawScales[0], canvas.getHeight() / drawScales[1]);
		canvas.setZoom(loadfactor)
		canvas.renderAll();
		resizeCanvas();
		canvas.calcOffset();
		drawFactor = (drawFactor * loadfactor);

		var objects = canvas.getObjects();
		// Access control of Objects
		for(var i in objects) {
			// replace on the i the 3 by the !== object.id to Edit the wished object
			// make the object wich should be editable selectable
			console.log(objects[i]);
			var objectId;
			var objectGroup = objects[i]._objects;

			objects[i]._objects.forEach(getType);
			function getType(item, index){
				if (item.type =='text') {
					console.log('index: ' + index +' Text: ' + item.text);
					objectId = item.text;
				}
				if (objectId == jQuery('#route').val()) {
					console.log('TRUE');
				}
			}
			for(var s in objects[i]._objects) {
				// Verify if the ID allready exists
				if(objects[i]._objects[s].type == 'text' && objectId !== jQuery('#route').val()) {
					verifyInput.push(objects[i]._objects[s].text)
				}
			}

			// remove any lost elements that are not a group otherways error in the next code
			try {
				if(objects[i]._objects.length < 1) {
					canvas.remove(objects[i]);
				}
			} catch (e) {}
			//console.log(jQuery('#route').val());
			//console.log(objectId);
			// set the route group selectable if matches with the route id.
			if(objects[i].type == 'group' && objectId !== jQuery('#route').val() && jQuery('#mode').attr('mode') == "edit") {
				objects[i].hasControls = false;
				objects[i].selectable = false;
				console.log('True');
			} else if(jQuery('#mode').attr('mode') == "read") {
				objects[i].hasControls = false;
				objects[i].selectable = false;
			} else {
				objects[i].hasControls = true;
				objects[i].selectable = true;
				editStatus = 2;
			}
		};
		console.log('End Init');
	}
	initialize();

	// resize canvas on window resize
	window.addEventListener('resize', resizeCanvas, false);

	/*
	* Set the Height of image to the height of the canvas on Window resize
	*
	*
	*/
	function resizeCanvas() {
		var factor = Math.min(jQuery('#image').width() / canvas.getWidth(), jQuery('#image').height() / canvas.getHeight());
		canvas.setHeight(jQuery('#image').height());
		canvas.setWidth(jQuery('#image').width());
		canvas.renderAll();
		//drawFactor = drawFactor * factor;
		canvas.setZoom(canvas.getZoom() * factor);
	}

	/*
	* Keep the lines connected while moving the points
	* Code 168, 171, 174 help from(modified): http://fabricjs.com/stickman
	*
	*/
	canvas.on('object:moving', function(e) {
		var p = e.target;
		var offset;
		if(p.type == 'circle') {
			var radius = p.radius;
			var tempRadius = radius;
			offset = tempRadius;
		} else if(p.type == 'text') {
			offset = 0;
		} else {
			offset = 0;
		}
		if(p.line1) {
			p.line1 && p.line1.set({ 'x2': p.left + offset, 'y2': p.top + offset });
		}
		if(p.line2) {
			p.line2 && p.line2.set({ 'x1': p.left + offset, 'y1': p.top + offset });
		}
		if(p.group1) {
			p.group1.set({ 'left': p.left + offset, 'top': p.top + offset });
		}
		canvas.requestRenderAll();
	});

	/*
	* Remove sible objects that are selectable, example while drawing
	* Code 184 - 198 help from (modified); https://stackoverflow.com/questions/43984328/fabricjs-removing-objects-line-from-canvas-but-not-all-objects-are-getting-rem?rq=1
	*
	*/
	function removeObjects() {
		var selection = canvas.getObjects();
		for(let i in selection) {
			if(selection[i].selectable == true) {
				canvas.remove(selection[i]);
			}
		}

		// set editstatus to = no route started
		editStatus = 0;
		canvas.remove(canvas.getActiveObject());
		canvas.discardActiveObject();
		canvas.renderAll();
		resizeCanvas();
	}

	/*
	* delete a selectable group,
	* example if a Route allready has drawing and the route gets deleted without deleting the drawing
	* Code 188 - 197 help from (modified); https://stackoverflow.com/questions/43984328/fabricjs-removing-objects-line-from-canvas-but-not-all-objects-are-getting-rem?rq=1
	*
	*/
	function removeGroup() {
		var selection = canvas.getObjects();
		for(let i in selection) {
			if(selection[i].selectable == true && selection[i].type == 'group') {
				canvas.remove(selection[i]);
				if(selection[i].type == 'group') {
					group.remove(selection[i]);
				}
			}
		}
	}

	// group the objects to have one path and remove the points between
	function groupObjects() {
		var objects = canvas.getObjects();
		var group = new fabric.Group([], {});
		for(var i in objects) {
			if(objects[i].selectable == true) {

				if(objects[i].fill !== '#666') {
					group.addWithUpdate(objects[i]);
					objects[i].selectable == false;
					//canvas.clear().renderAll();
					canvas.remove(objects[i]);
				} else {
					canvas.remove(objects[i]);
				}
			}
		}
		canvas.add(group);
		canvas.renderAll();
	}

	//put the Objects in a Array and pass to the fluid form
	function getObjects() {
		groupObjects();
		jQuery('#fluidSend').attr('value', JSON.stringify(canvas));
	}

	// keep global to guarantee the connection to the next circle
	var firstLine;
	var lastCircle;
	var gradeColor;
	var gradeValue = parseInt(jQuery('#grade').val());
	setColor();
	jQuery("#grade").change(function() {
		removeObjects();
		setColor();
	});

	var drawSize = 1;
	jQuery("#size").change(function() {
		drawSize = (jQuery("#size").val() / 10) + 1;
		removeObjects();
		console.log(drawSize);
	});

	// set the color depending on the Grade
	function setColor() {
		gradeValue = parseInt(jQuery('#grade').val());
		switch (true) {

			// climbinggrades >= from <= till
			case gradeValue >= 0 && gradeValue <= 7:
				gradeColor = '#2FFFFF'; // lightblue
				break;
			case gradeValue >= 8 && gradeValue <= 13:
				gradeColor = '#E85BFB'; // pink
				break;
			case gradeValue >= 13 && gradeValue <= 18:
				gradeColor = '#16FC16'; // green
				break;
			case gradeValue >= 19 && gradeValue <= 24:
				gradeColor = '#FFF00D'; // yellow
				break;
			case gradeValue >= 25 && gradeValue <= 30:
				gradeColor = '#FB5B5B'; // red
				break;
			case gradeValue >= 31 && gradeValue <= 36:
				gradeColor = '#5571FF'; // darkblue
				break;
			default:
				gradeColor = '#666' // grey

		}

	}

	/*
	TODO: identify the first point of one line
	*/
	canvas.on('mouse:dblclick', function(e) {
		var pointer = canvas.getPointer(event.e);
 		var posX = pointer.x;
 		var posY = pointer.y;
		if (editStatus === 0 ) {
			addRoute(posX, posY);
			console.log('Status 0');
			return;
		}
		if (editStatus === 1 ) {
			addP(posX, posY);
			console.log('Status 1');
			return;
		}

		if (editStatus === 2 ) {
			addP(posX, posY);
			window.alert(jQuery('#translatedAlert-' + 1).attr('data-trans'));
			console.log('Status 2');
			return;
		}
		console.log(editStatus);

	});

	jQuery('#editStatus').attr('data-edit', editStatus);

	// initialize Route
	function addRoute(x, y) {

		var objectId = jQuery('#objectId').val();

		// verify if id allready exists
		if(objectId !== '' && verifyInput.includes(objectId) === false && editStatus === 0) {

			startCircle = makeText(x - 4, y - 4, null, null, objectId, gradeColor);
			lastCircle = makeCircle(x - 4, y - 40, null, null, 4, "#666", null);
			canvas.add(startCircle, lastCircle);
			console.log('Index', startCircle.index);

			/*
	        *  x1 and y1 = x and y axis start of line
	        *   x2 and y2 = x and y axis end of line
			*	by changing y1 also change y2 from the line before, to keep the connection to the circle
	        */
			firstLine = makeLine([startCircle.left,startCircle.top,lastCircle.left + 4 , lastCircle.top + 4], gradeColor);
			canvas.add(firstLine);
			canvas.moveTo(startCircle, 999);
			console.log(firstLine);

			// (left, top, line1, line2, radius)

			startCircle.line2 = firstLine;
			lastCircle.line1 = firstLine;


			editStatus = 1;

		} else if(editStatus > 0) {
			// alert if route allready started
			window.alert(jQuery('#translatedAlert-' + 1).attr('data-trans'));
		} else {
			// alert if invalid id
			window.alert(jQuery('#translatedAlert-' + 0).attr('data-trans'));
		}

	}

	// Add connecting points to the Route
	function addP(x, y) {

		if(editStatus == 1) {
			newCircle = makeCircle(x - 4, y - 4, null, null, 4, "#666", null);
			var newLine = makeLine([lastCircle.left + lastCircle.radius, lastCircle.top + lastCircle.radius, newCircle.left + newCircle.radius, newCircle.top+ newCircle.radius], gradeColor);
			lastCircle.line2 = newLine;
			newCircle.line1 = newLine;
			firstLine = newLine;
			lastCircle = newCircle;
			canvas.add(firstLine);
			canvas.add(newCircle);

		} else if(editStatus == 3) {
			// alert if route allready ended
			window.alert(jQuery('#translatedAlert-' + 2).attr('data-trans'));
		} else {
			// alert if route not started
			window.alert(jQuery('#translatedAlert-' + 3).attr('data-trans'));
		}

	}

	// Add End of the Route
	function addEndpoint() {
		console.log(editStatus);
		if(editStatus == 1 ) {
			var newLine = makeLine(
					[lastCircle.left + lastCircle.radius,
					lastCircle.top + lastCircle.radius,
					lastCircle.left + lastCircle.radius,
					lastCircle.top - 25],
				gradeColor
			);
			lastCircle.line2 = newLine;
			finalCircle = makeCircle(
				newLine.get('x2') - (8),
				newLine.get('y2') - (8),
				newLine, null, 8, gradeColor, true
			);
			lastCircle = finalCircle;
			firstLine = newLine;
			canvas.add(firstLine);
			canvas.add(finalCircle);

			editStatus = 3;
		} else if(editStatus == 3) {
			// alert if endpoint allready inserted
			window.alert(jQuery('#translatedAlert-' + 2).attr('data-trans'));
		} else {
			// alert if route not started
			window.alert(jQuery('#translatedAlert-' + 3).attr('data-trans'));
		}

	}

	/*
	* draw line
	* Attributes from: http://fabricjs.com/docs/fabric.Line.html
	*/
	function makeLine(coords, color) {

		return new fabric.Line(coords, {
			fill: color,
			stroke: color,
			strokeWidth: 2 * drawSize,
			selectable: true,
			hasControls: false,
			evented: false,
			width: 10 * drawSize,
			height: 60 * drawSize
		});

	}

	/*
	* draw circle
	* Attributes from: http://fabricjs.com/docs/fabric.Circle.html
	* addWithUpdate() problem adding objects to group dynamically: https://stackoverflow.com/questions/33751273/how-to-add-objects-in-group-dynamically-in-fabric-js/33751501
	*/
	function makeCircle(left, top, line1, line2, radius, color, arrow) {

		var c = new fabric.Circle({
			left: left,
			top: top,
			strokeWidth: 1,
			radius: radius * drawSize,
			fill: color,
			stroke: '#000'
		});
		if(document.getElementById('checkend').checked && arrow == true) {
			var groupArrow = new fabric.Group([], {});
			var space = 20 * drawSize;
			var arrow1 = makeArrow(left + space + radius, top + space + radius, gradeColor);
			var lineArrowRight = makeLine([left + radius, top + radius, left + space, top + radius], '#000');
			var lineArrowDown = makeLine([left + space, top + radius, left + space, arrow1.top - arrow1.height], '#000');
			console.log('arrow: ', groupArrow);
			groupArrow.addWithUpdate(arrow1);
			groupArrow.addWithUpdate(lineArrowRight);
			groupArrow.addWithUpdate(lineArrowDown);
			canvas.add(groupArrow);
			c.group1 = groupArrow;
		}
		c.hasControls = false;
		/* line connections around circle */
		c.line1 = line1;
		c.line2 = line2;

		return c;
	}

	/*
	* add the id to the path
	* Attributes from: http://fabricjs.com/docs/fabric.Text.html
	*/
	function makeText(left, top, line1, line2, text, color) {
		var t = new fabric.Text(text, {
			top: top,
			left: left,
			fontFamily: "Arial",
			fontSize: 12 * drawSize,
			strokeWidth: 1 * drawSize,
			stroke: '#000',
			originX: 'center',
			originY: 'center',
			backgroundColor: color,
			angle: 90
		})
		t.hasControls = false;
		/* line connections around element */
		t.line1 = line1;
		t.line2 = line2;
		return t;
	}

	/*
	* draw the arrow for rappel
	* http://fabricjs.com/docs/fabric.Triangle.html
	*/
	function makeArrow(left, top, color) {
		return new fabric.Triangle({
			fill: color,
			stroke: '#000',
			left: left,
			top: top,
			angle: 180,
			height: 10 * drawSize,
			width: 10 * drawSize,
			strokeWidth: 2 * drawSize,
			selectable: true,
			hasControls: false,
			evented: false
		});
	}

})();
