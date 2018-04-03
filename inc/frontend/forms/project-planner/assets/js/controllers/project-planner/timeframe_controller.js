import { Controller } from "stimulus"

export default class extends Controller {
  static targets = [
    'next',
    "timeframe",
    "timeframeList"
  ]

  toggle(e) {
    e.preventDefault()

    this.timeframeListTargets.forEach((el, i) => {
      el.classList.remove('is-selected')
    })

    e.currentTarget.classList.toggle("is-selected")

    this.set()

    this.toggleNextButton(this.timeframeTarget.value.length > 0);
  }

  set() {
    this.timeframeListTargets.forEach((el, i) => {
      if (el.classList.contains('is-selected')) {
        this.timeframeTarget.value = el.dataset.timeframe
      }
    })
  }

  toggleNextButton(show) {
    if (show) {
      this.fadeIn(this.nextTarget)
      this.nextTarget.click()
    } else {
      this.nextTarget.classList.add('is-invisible')
    }
  }

  fadeIn(el) {
    if (!el.classList.contains('is-invisible')) return;

    el.style.opacity = 0;

    setTimeout(() => {
      el.classList.remove('is-invisible')
      el.style.opacity = 1;
    }, 200)
  }
}
