class MovingShit {
    pos1 = {x: 0, y: 100};
    pos2 = {x: 300, y: 100};
    offset = {};
    pos = {};
    left = false;

    constructor(element) {
        this.e = element;
        this.e.addEventListener('mousemove', (e) => {this.drag(e)});
        this.e.addEventListener('mouseup', (e) => {
            this.setOffset(e);
            this.goToPos();
        });
        setInterval(this.move, 1);
    }   

    drag = (e) => {
        if (e.buttons === 1) {
            this.setOffset(e);
            this.setDirection(e);
            this.pos.x = e.x - this.offset.x;
            this.setPos(this.pos);
            console.log(this.left);
        }
    }

    setOffset = (e) => {
        if (Object.entries(this.offset).length === 0) {
            this.offset.x = e.offsetX;
            this.offset.y = e.offsetY;
        }
    }

    setDirection = (e) => {
        this.left = (this.pos.x > e.x - this.offset.x ? true : false);
    }
    
    setPos = (point) => {
        this.e.style.left = point.x + 'px';
        this.e.style.top = point.y + 'px';
    }

    goToPos = () => {
        if (this.left) {
            this.pos = Object.assign({}, this.pos1);
        } else {
            this.pos = Object.assign({}, this.pos2);
        }
        this.setPos(this.pos);
    }
}
e = new MovingShit(document.querySelector('div'));