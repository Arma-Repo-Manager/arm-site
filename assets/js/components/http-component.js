/**
 * @author flaver <zerbarian@outlook.com>
 * @copyright (c) 2018 arm, flaver
 * 
 * Wrapper for http request
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