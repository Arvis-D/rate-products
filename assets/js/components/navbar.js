import anime from 'animejs/lib/anime.es.js';

export default class Navbar {
  responsiveOpen = false;
  authInResponsive = false;
  linksInResponsive = false;
  breakpoints = [884, 700]

  constructor () {
    this.setDom();
    this.swapResponsiveIfNecessary();
    this.setEventListeners();
  }

  swapResponsiveIfNecessary = () => {
    let width = window.innerWidth;
    let [first, second] = this.breakpoints;

    if (width < first && !this.linksInResponsive) {
      this.linksInResponsive = true;
      this.responsive.appendChild(this.links)
    } else if (this.linksInResponsive && width > first) {
      this.linksInResponsive = false;
      this.navbar.insertBefore(this.links, this.search)
    }

    if (width < second && !this.authInResponsive) {
      this.authInResponsive = true;
      this.responsive.appendChild(this.authControls)
    } else if (this.authInResponsive && width > second) {
      this.authInResponsive = false;
      this.navbar.insertBefore(this.authControls, this.burger)
    }
  }

  toggleResponsive = () => {
    if (this.responsiveOpen) {
      this.responsiveOpen = false;
      anime({
        targets: this.responsive,
        translateX: '0%',
        opacity: 0,
        duration: 200,
        easing: 'easeInOutQuad',
        complete: () => {
          this.responsive.classList.toggle('--open')
        }
      })
    } else {
      this.responsiveOpen = true;
      anime({
        targets: this.responsive,
        translateX: '100%',
        opacity: 1,
        duration: 200,
        easing: 'easeInOutQuad',
        begin: () => {
          this.responsive.classList.toggle('--open')
        }
      })
    }
  }

  setDom() {
    this.navbar = document.querySelector('.navbar-custom')
    this.burger = this.navbar.querySelector('.burger')
    this.responsive = this.navbar.querySelector('.navbar-responsive')
    this.links = this.navbar.querySelector('.nav-links')
    this.authControls = this.navbar.querySelector('.nav-auth-controls')
    this.search = this.navbar.querySelector('.nav-search')
  }

  setEventListeners() {
    window.addEventListener('resize', () => {
      this.swapResponsiveIfNecessary();
    });

    this.burger.addEventListener('click', () => {
      this.burger.classList.toggle('burger-close');
      this.toggleResponsive();
    });
  }
}