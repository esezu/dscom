var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// create canvas using template literals and attach to body/DOM
document.querySelector('body').innerHTML = '<canvas id="stage" width="400" height="400">';

// grab the reference to the canvas for later use (resizing dynamically)
var stageCanvas = document.querySelector('#stage');

// color palette for random color selection
var col_amethyst = [155, 89, 182];
var col_pomegranate = [192, 57, 43];
var col_midnightblue = [44, 62, 80];
var col_midnighterblue = [24, 28, 40];
var col_sunflower = [241, 196, 15];
var col_alizarin = [231, 76, 60];
var col_clouds = [236, 240, 241];
var col_wetasphalt = [52, 73, 94];
var col_red = [230, 22, 2];
var col_green = [125, 240, 72];

var palette = [col_green, col_clouds, col_wetasphalt, col_wetasphalt, col_wetasphalt, col_wetasphalt, col_wetasphalt];

var Particle = function () {
  function Particle(_ref) {
    var canvas = _ref.canvas,
        color = _ref.color,
        speed = _ref.speed,
        lineWidth = _ref.lineWidth,
        vx = _ref.vx,
        vy = _ref.vy,
        canvaspad = _ref.canvaspad;

    _classCallCheck(this, Particle);

    this.canvas = canvas;
    this.ctx = canvas.getContext('2d');
    this.speed = speed || 12;
    this.lineWidth = lineWidth || 2;
    this.canvaspad = canvaspad || 100;
    // this.angle = angle || Math.random() * Math.PI * 2;
    this.cycle = 40;
    this.step = Math.floor(Math.random() * this.cycle);
    this.x = canvas.width * Math.random();
    this.y = canvas.height * Math.random();
    this.vx = vx !== undefined ? vx : 0;
    this.vy = vy !== undefined ? vy : 0;
    this.history = [];
    this.maxHistory = 10;
    this.color = color || [0, 0, 0];
  }

  _createClass(Particle, [{
    key: 'update',
    value: function update() {
      this.step = (this.step + 1) % this.cycle;
      var a = Math.sin(this.step / this.cycle * 3.14);
      a = a / 2 + 0.5;

      // update position with vector
      this.x += this.vx;
      this.y += this.vy;
      // update vector
      this.vx = this.vx * 0.98 + (Math.random() * this.speed * 2 - this.speed) * 0.12;
      this.vy = this.vy * 0.98 * a + (Math.random() * this.speed * 2 - this.speed) * 0.12;

      if (this.x < 0 - this.canvaspad) {
        return this.kill();
      }
      if (this.y < 0 - this.canvaspad) {
        return this.kill();
      }
      if (this.x > this.canvas.width + this.canvaspad) {
        return this.kill();
      }
      if (this.y > this.canvas.height + this.canvaspad) {
        return this.kill();
      }

      this.history.unshift({ x: this.x, y: this.y });
      if (this.history.length > this.maxHistory) {
        this.history.pop();
      }

      for (var i = 1; i < this.history.length; i++) {
        this.history[i].x = this.history[i].x * 0.5 + this.history[i - 1].x * 0.5;
        this.history[i].y = this.history[i].y * 0.5 + this.history[i - 1].y * 0.5;
      }
      return true;
    }
  }, {
    key: 'kill',
    value: function kill() {
      this.canvas = null;
      this.ctx = null;
      return false;
    }
  }, {
    key: 'draw',
    value: function draw() {
      this.ctx.beginPath();
      this.ctx.lineWidth = this.lineWidth;
      this.ctx.lineJoin = "round";
      this.ctx.lineCap = "round";

      this.ctx.moveTo(this.x, this.y);
      for (var i = 0; i < this.history.length; i++) {
        this.ctx.lineTo(this.history[i].x, this.history[i].y);
      }
      this.ctx.strokeStyle = 'rgba(' + this.color + ', ' + 1 + ')';
      this.ctx.stroke();
    }
  }]);

  return Particle;
}();

// create a Doodle class


var Doodle = function () {
  function Doodle(_ref2) {
    var _this = this;

    var canvas = _ref2.canvas,
        backgroundColor = _ref2.backgroundColor,
        palette = _ref2.palette,
        maxParticles = _ref2.maxParticles;

    _classCallCheck(this, Doodle);

    this.canvas = canvas;
    this.particles = [];
    this.palette = palette;
    this.backgroundColor = backgroundColor || [0, 0, 0];
    this.numParticles = maxParticles || 10;

    // grab reference to the context for drawing into
    this.ctx = canvas.getContext('2d');

    // setup resize listener, and bind to setup (with this as scope)
    window.addEventListener('resize', function () {
      return _this.setup();
    });

    // run setup
    this.setup();

    // setup draw loop
    setInterval(function () {
      return _this.draw();
    }, 1500 / 29.9);
  }

  _createClass(Doodle, [{
    key: 'setup',
    value: function setup() {
      // set canvas width to window width
      this.canvas.width = window.innerWidth;
      // set canvas height to window height
      this.canvas.height = window.innerHeight;
      this.fill({
        ctx: this.ctx,
        color: 'rgba(' + this.backgroundColor + ', 1)',
        rect: { x: 0, y: 0, width: this.canvas.width, height: this.canvas.height }
      });
    }
  }, {
    key: 'draw',
    value: function draw() {

      if (this.particles.length < this.numParticles) {
        this.particles.push(new Particle({
          canvas: this.canvas,
          color: this.palette[Math.floor(Math.random() * this.palette.length)]
        }));
      }

      this.fill({
        ctx: this.ctx,
        color: 'rgba(' + this.backgroundColor + ', 0.4)',
        rect: { x: 0, y: 0, width: this.canvas.width, height: this.canvas.height }
      });

      this.particles = this.particles.filter(function (p) {
        if (p.update()) {
          p.draw();
          return true;
        }
        return false;
      });
    }
  }, {
    key: 'fill',
    value: function fill(_ref3) {
      var ctx = _ref3.ctx,
          color = _ref3.color,
          rect = _ref3.rect;

      ctx.beginPath();
      ctx.rect(rect.x, rect.y, rect.width, rect.height);
      ctx.fillStyle = color;
      ctx.fill();
    }
  }]);

  return Doodle;
}();

var doodle = new Doodle({
  canvas: stageCanvas,
  maxParticles: 100,
  backgroundColor: col_midnighterblue,
  palette: palette
});