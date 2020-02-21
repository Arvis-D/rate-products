class A {
    constructor(otherShit) {
        this.otherShit = otherShit;
    }

    sayShit = () => {
        alert(this.otherShit.a)
    }
}

class B {
    a = 'Ī am the other shit';
}

a = new B;
s = new A(a);

s.otherShit.a = 'dsfsdfsdf';

alert(a.a)