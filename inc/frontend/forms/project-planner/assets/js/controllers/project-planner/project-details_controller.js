import { Controller } from "stimulus"

export default class extends Controller {
  static targets = [
    'file',
    'label'
  ]

  update(e) {
    if (e.target.files.length === 0) {
      this.labelTarget.innerHTML = 'Select File'
      return
    }

    this.labelTarget.innerHTML = e.target.files[0].name
  }
}
