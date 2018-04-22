
function ValueSelector($control,titles,values,defaultValue){
    var $down=$control.find('.left');
    var $up=$control.find('.right');
    var $value=$control.find('.value');
    var currentIndex=0;
    var self=this;

    
    this.selectIndex = function(index) {
        if(index>=0 && index<values.length) {
            currentIndex = index;
            var title=titles[currentIndex];
            $value.html(title);
            $(self).trigger("valueChanged", [currentIndex, values[currentIndex]]);
        }
    }

    this.selectValue = function(value) {
        var index=values.indexOf(value);
        if(index>=0) {
            self.selectIndex(index);
            $(self).trigger("valueChanged", [currentIndex, value]);
        }
    }

    function prepare(){
        $down.click(function (e) {
            if(currentIndex>0){
                currentIndex--;
                self.selectIndex(currentIndex);
            }
        });

        $up.click(function (e) {
            if(currentIndex<values.length){
                currentIndex++;
                self.selectIndex(currentIndex);
            }
        });
        if(typeof defaultValue=='undefined')
            self.selectIndex(0);
        else
            self.selectValue(defaultValue);
    }

    prepare();
}
