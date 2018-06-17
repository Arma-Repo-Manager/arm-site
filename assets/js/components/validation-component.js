/**
 * @author herrx2000
 * @copyright (c) 2018 arm, herrx2000
 * 
 * validation for form
 */

export class httpComponent {

    constructor(app) {
        this.app = app;
    }

    get(url) {
        let ajax = this.app.get('ajax');
        let result = null;
        ajax.get(url).then((response) => {
            if(response.status === 200) {
                result = response.data;
            }
            return result;
        });
    }
}