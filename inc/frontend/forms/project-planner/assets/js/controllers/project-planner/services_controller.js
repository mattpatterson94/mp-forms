import { Controller } from "stimulus"

export default class extends Controller {
  static targets = [
    "next",
    "services",
    "serviceList",
  ]

  toggle(e) {
    e.preventDefault()
    e.currentTarget.classList.toggle("is-selected")

    this.set()

    this.toggleNextButton(this.servicesTarget.value.length > 0);
  }

  set() {
    var service_list = []

    this.serviceListTargets.forEach((el, i) => {
      if (el.classList.contains('is-selected')) {
        service_list.push(el.dataset.service)
      }
    })

    this.servicesTarget.value = service_list.join(', ')
  }

  toggleNextButton(show) {
    if(show) {
      this.fadeIn(this.nextTarget)
    } else {
      this.nextTarget.classList.add('is-invisible')
    }
  }

  fadeIn(el) {
    if(!el.classList.contains('is-invisible')) return;

    el.style.opacity = 0;

    setTimeout(() => {
      el.classList.remove('is-invisible')
      el.style.opacity = 1;
    }, 200)
  }
}
