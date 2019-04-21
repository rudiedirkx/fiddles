/* From https://gist.github.com/MadRabbit/996893 */
function Bezier(p1, p2, p3, p4) {
	var	Cx = 3 * p1,
		Bx = 3 * (p3 - p1) - Cx,
		Ax = 1 - Cx - Bx;

	var	Cy = 3 * p2,
		By = 3 * (p4 - p2) - Cy,
		Ay = 1 - Cy - By;

	function bezier_x(t) { return t * (Cx + t * (Bx + t * Ax)); }
	function bezier_y(t) { return t * (Cy + t * (By + t * Ay)); }
	function bezier_x_der(t) { return Cx + t * (2*Bx + 3*Ax * t); }
	function find_x_for(t) {
		var x = t, i = 0, z;

		while (i < 5) {
			z = bezier_x(x) - t;

			if (Math.abs(z) < 1e-3) break;

			x -= z / bezier_x_der(x);
			i++;
		}

		return x;
	}

	return function(t) {
		return bezier_y(find_x_for(t));
	};
}

function Animate(cont, prop, targetValue, duration, cb, easing) {
	var	initialValue = cont[prop],
		distance = targetValue - initialValue,
		steps = duration * 60,
		step = 0,
		easer = easing || Bezier(.5, .5, .5, .5), // linear
		iterator = function() {
			var pct = ++step / steps;
			cont[prop] = initialValue + distance * easer(pct);
			if (step >= steps) {
				cb && cb();
			}
			else {
				requestAnimationFrame(iterator);
			}
		};

	iterator();
}
