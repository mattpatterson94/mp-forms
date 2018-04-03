import { Controller } from "stimulus"

export default class extends Controller {
  static targets = [
    'page',
    'gettingStarted',
    'progressBar',
    'response',
    'submit'
  ]

  connect(e) {
    this.page = 0

    this.gettingStartedTarget.click()
  }

  next(e) {
    e.preventDefault()

    e.currentTarget.style.display = 'none';
    this.page++
    this.togglePages()

    if(this.page !== 1) this.scrollTo(this.pageTargets[this.page], 800)
    if(this.page == 2) {
      this.showProgressBar()
    }
    this.updateProgressBar()
  }

  submit(e) {
    var $this = this

    e.preventDefault()

    if(e.target.value !== 'Submit') return

    var xhttp = new XMLHttpRequest()

    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        $this.handleSubmitResponse($this, xhttp.responseText)
      }
    }

    var url = this.element.action
    var action = this.element.dataset.formAction

    this.submitTarget.innerHTML = "Submitting... <i class='fa fa-spinner fa-spin'></i>"

    xhttp.open("POST", url, true)
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

    var form_values = this.formValues(action)

    xhttp.send(form_values)
  }

  handleSubmitResponse($this, responseText) {
    var response = JSON.parse(responseText)

    if(response.status == 'failure') {
      var notification_class = 'notification is-danger'
      $this.submitTarget.innerHTML = 'Submit'
    } else {
      var notification_class = ''

      $this.pageTargets.forEach((el) => {
        el.style.display = 'none';
      });

      $this.progressBarTarget.style.display = 'none'
    }

    $this.responseTarget.innerHTML = "<div class='is-inline-block'><div class='has-text-centered "+notification_class+"'>" + response.message + "</div></div>"

    $this.responseTarget.style.opacity = 0
    $this.responseTarget.classList.remove('is-hidden')

    setTimeout(() => {
      $this.responseTarget.style.opacity = 1
    }, 100)
  }

  formValues(action) {
    var key_value_pairs = []
    var form = this.element

    for (var i = 0; i < form.elements.length; i++) {
      var e = form.elements[i]
      key_value_pairs.push(encodeURIComponent(e.name) + "=" + encodeURIComponent(e.value))
    }

    key_value_pairs.push('action=' + action)

    var query_string = key_value_pairs.join("&")

    return query_string
  }

  togglePages() {
    for (let i = 0; i <= this.page; i++) {
      if(!this.pageTargets[i].classList.contains('is-visible')) {
        this.pageTargets[i].style.opacity = 0
        this.pageTargets[i].classList.add('is-visible')

        var height = this.pageTargets[i].clientHeight + 'px'
        this.pageTargets[i].style.height = '0px'

        setTimeout(() => {
          this.pageTargets[i].style.opacity = 1
          this.pageTargets[i].style.height = height
        }, 100);
      }
    }
  }

  showProgressBar() {
    this.progressBarTarget.style.opacity = 0
    this.progressBarTarget.classList.remove('is-hidden')

    setTimeout(() => {
      this.progressBarTarget.style.opacity = 1
    }, 100)
  }

  updateProgressBar() {
    var current_percentage = (this.page / this.pageTargets.length) * 100
    this.progressBarTarget.value = current_percentage
    this.progressBarTarget.innerHTML = current_percentage + '%'
  }

  scrollTo(element, duration) {
    var elementY = this.getElementY(element)
    var startingY = window.pageYOffset
    var diff = elementY - startingY - 100
    var start

    // Bootstrap our animation - it will get called right before next frame shall be rendered.
    window.requestAnimationFrame(function step(timestamp) {
      if (!start) start = timestamp
      // Elapsed milliseconds since start of scrolling.
      var time = timestamp - start
      // Get percent of completion in range [0, 1].
      var percent = Math.min(time / duration, 1)

      window.scrollTo(0, startingY + diff * percent)

      // Proceed with animation as long as we wanted it to.
      if (time < duration) {
        window.requestAnimationFrame(step)
      }
    })
  }

  getElementY(element) {
    return window.pageYOffset + element.getBoundingClientRect().top
  }
}
