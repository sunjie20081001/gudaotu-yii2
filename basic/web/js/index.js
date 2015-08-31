/**
 * Created by sun on 8/26/15.
 */

//文章编辑模块

//ajax upload image 异步上传　图片
(function(w, $){

    function UploadImg(options){
        var self = this;
        self.uploadUrl = options.url;
        self.imgs = options.imgs; //存储已经上传的　页面数据

        self.uploadimg = options.uploadimg;
        self._init();
    }

    UploadImg.prototype._init = function(){
        var self = this;
        self._render();
        self._bindEvents();
    }

    UploadImg.prototype._render = function(){
        var self = this;
        var html = '<div id="uploadimg-container" class="uploadimg-container"><div class="uploadimg-background"></div><div class="uploadimg-wrap">';
        html += '<div class="uploadimg-input"><a href="javascript:void(0);" class="uploadimg-a"><span class="uploadimg-text">上传图片</span><input type="file" class="j-uploadimg-files" name="files][" id="uploadimg-file" multiple/></a></div>';
        html += '<div class="uploadimg-lists"></div>';
        html += '</div></div>';
        $('body').append(html);
        self._renderImgs();
    }


    UploadImg.prototype._renderImgs = function(){
        var self = this;
        var html  = '<div class="uploadimg-items">';
        for(i in self.imgs){
            html +='<div class="uploadimg-item" data-img="'+self.imgs[i]+'"><img src="'+self.imgs[i]+'"></div>';
        }
        html += '</div>';
        html += '<div class="uploadimg-insert uploadimg-btn">插入</div><div class="uploadimg-abort uploadimg-btn">取消</div>';
        $('.uploadimg-lists').html(html);
    }

    /**
     * 　图片上传服务器
     * @private
     */
    UploadImg.prototype._bindEvents = function(){
        var self = this;
        $('.j-uploadimg-files').change(function(e){
            //上传中...
            $('.j-uploadimg-files').hide();
            $('.uploadimg-a .uploadimg-text').text("上传图片中...");
            self._uploadServer(e.target.files, function(){
                //上传完成..
                $('.j-uploadimg-files').show();
                $('.uploadimg-a .uploadimg-text').text("上传图片");
            });

        });

        //图片放大
        $(document).on('mouseenter','.uploadimg-item',function(){
            console.log('加载');
            var imgurl = $(this).data('img');
            $(this).append('<div class="uploadimg-fang"><img src="'+imgurl+'"></div>');
        }).on('mouseleave','.uploadimg-item',function(){
            $(this).find('.uploadimg-fang').remove();
        });

        $(document).on('click','.uploadimg-item', function(){
            if($(this).hasClass('selected')){
                $(this).removeClass('selected');
            }else{
                $(this).addClass('selected');
            }
        });

        $(document).on('click', '.uploadimg-insert',function(){
            //将选中的图片插入到当前
            $('.uploadimg-item').each(function(){
                if($(this).hasClass('selected')){
                    self.section.imgs.push($(this).data('img'));
                    $(this).removeClass('selected');
                }
            });

            self.insertCallback();
            self._hide();
        });

        $(document).on('click', '.uploadimg-abort',function(){
            self._hide();
        });

    }
    UploadImg.prototype._uploadServer = function(files, callback){
        var self = this;

        var formData = new FormData();
        for(i in files){
            formData.append('UploadImage[imageFiles][]',files[i]);
        }

        var xhr = new XMLHttpRequest();
        xhr.onload = function(){
            if(xhr.status == 200) {
                console.log('上传成功');
                //上传成功后，数据处理
                var data = JSON.parse(xhr.response.toString());
                console.log(data);
                if(data.status == 0){
                    //返回数据成功
                    for(i in data.data){
                        self.imgs.push(data.data[i]);
                    }
                    console.log(self.imgs);
                    self._renderImgs();
                }
            }
            callback();
        }

        xhr.open("POST",self.uploadUrl, true);
        xhr.send(formData);
    }

    UploadImg.prototype._show = function(obj, callback){
        var self = this;
        $('.uploadimg-container').show();
        self.section = obj;
        self.insertCallback = callback;
    }

    UploadImg.prototype._hide = function(){
        $('.uploadimg-container').hide();
    }

    w.UploadImg = UploadImg;
})(window, jQuery);

(function(w, $){

    function Section(option){
        var self = this;

        self.id = option.id;
        self.title = option.title;
        self.imgs = option.imgs;
        self.desc = option.desc;
        self.video = option.video;

        self.$el = $('#section-' + self.id);
    }

    /**
     * 初始化 各种事件
     * @private
     */
    Section.prototype._init = function(){

    }

    /**
     * 渲染自身,模板,返回js
     * @private
     */
    Section.prototype._render =  function(){
        var self = this;
        var html = '<div id="section-'+self.id+'" data-id ="'+self.id+'"  class="section-item">';
        html += '<div class="section-num">'+self.id+'</div>';
        html += '<div class="section-title section-item-i"><label>标题:</label><input type="text" class="j-section-text" data-tag="title" value="'+self.title+'" placeorder="标题" /></div>';
        html += '<div class="section-video section-item-i"><label>视频:</label><input type="text" class="j-section-text" data-tag="video" value="'+self.video+'"></div>';
        var imgHtml = '<label>图片:</label><div class="section-imgs-list">';
        for(i in self.imgs){
            imgHtml += '<div class="section-img j-section-img" data-num="'+i+'"><img src="'+self.imgs[i]+'"></div>';
        }
        imgHtml　+= '<div class="section-img add-img">加图</div></div>';
        html += '<div class="section-imgs section-item-i">'+imgHtml+' </div>';
        html += '<div class="section-desc section-item-i"><label>描述:</label><textarea class="j-section-text" data-tag="desc" row="3">'+self.desc+'</textarea></div>';
        html += '<div class="section-button"><div class="section-button-minus sec-btn">-</div><div class="section-button-add sec-btn">+</div></div>';
        html += '</div>';

        return html;
    }

    Section.prototype._toJson = function(){
        var self = this;
        return {title : self.title, video:self.video, imgs : self.imgs, desc : self.desc};
    }

    /**
     * 上传图片
     * @private
     */
    Section.prototype._addImage = function(){
    }


    Section.prototype._delImage = function(){
    }

    w.Section = Section;
})(window, jQuery);

(function(w,$, Section, UploadImg){

    // section :{string title, array imgs, string desc} 标题, 图片组, 描述
    // options.id , options.data;
    function Post(options){
        var self = this;

        self.id = options.id;
        var data = options.data;
        self.sections = new Array();
        var imgs = new Array(); //图库
        for(i in data){
            data[i].id = i;
            self.sections.push(new Section(data[i]));
            imgs = imgs.concat(data[i].imgs);
        }

        if(data.length == 0){
            self.sections.push(new Section({'id':0, 'title':'','imgs':[],'video':'','desc':''}));
        }

        self.$el = $('#post-content-wrap');

        self.uploadimg = new UploadImg({'url' :'/post/upload', 'imgs':imgs});

        self.specialImgSection = new Section({'id':0, 'title':'','imgs':[],'video':'','desc':''});
        self._init();
    }

    /**
     * 初始化
     * @private
     */
    Post.prototype._init = function(){
        var self = this;
        self._render();
        self._bindEvents();
        //绑定事件
    }

    Post.prototype._bindEvents = function(){
        var self = this;
        //　增加　步骤
        $(document).on('click', '.section-button-minus',function(){
            //减少
            console.log('减少');

            //最后一个不能减少，也就是说　初始化必须有一个步骤
            if(self.sections.length == 1){
                console.log('最后一个步骤不允许删除．．．');
                return false;
            }
            var id = $(this).parents('.section-item').data('id');
            self._removeSection(id);

        });

        $(document).on('click', '.section-button-add',function(){
            console.log("增加步骤");
            var id = $(this).parents('.section-item').data('id');
            self._addSection(id);
        });

        //标题修改
        //视频修改
        //描述修改
        $(document).on('change','.j-section-text',function(){
            var id = $(this).parents('.section-item').data('id');
            var tag = $(this).data('tag');
            console.log(id);
            console.log(tag);
            console.log($(this).val());
            if(tag == 'title') {
                self.sections[id].title = $(this).val();
            }
            if(tag == 'video') {
                self.sections[id].video = $(this).val();
            }
            if(tag == 'desc') {
                self.sections[id].desc = $(this).val();
            }
        });

        //图片修改　最复杂　最后
        $(document).on('click','.add-img',function(){
            console.log($(this));
            var id = $(this).parents('.section-item').data('id');
            self.uploadimg._show(self.sections[id],function(){
                self._renderSections();
            });
        });

        $(document).on('click', '.j-section-img',function(){
            var id = $(this).parents('.section-item').data('id');
            var imgId = $(this).data('num');
            self.sections[id].imgs.splice(imgId,1);
            self._renderSections();
        });

        //处理特殊图
        $(document).on('click','.special-img',function(){
            self.uploadimg._show(self.specialImgSection,function(){
                var simg = self.specialImgSection.imgs.pop();
                if(simg) {
                    $('.special-img').html('<img src="'+simg+'">');
                    self.specialImgSection.imgs = new Array();

                    self.$specialImg.val(simg);
                }

            });
        });

    }

    Post.prototype._render = function(){
        var self = this;
        var html = "<div id='post-content-wrap' class='form-control post-edit-contaner'>";
        html += '</div>';
        $('#'+self.id).after(html);
        self.$el = $('#post-content-wrap');
        $('#'+self.id).hide();
        self._renderSections();

        self.$specialImg =$('#post-img');
        var htmlImg = $('#post-img').val()?'<img src="'+self.$specialImg.val()+'">':'增加图片';
        self.$specialImg.after('<div class="special-img">'+htmlImg+'</div>');

        self.$specialImg.hide();
    }

    /**
     *
     * @private
     */
    Post.prototype._renderSections = function(){
        var self = this;
        var html = '';
        for(i in self.sections){
            var h = self.sections[i]._render();
            html += h;
        }
        self.$el.html(html);
    }

    /**
     * 在　id 之后增加　id , 更改所有的　id
     * @param id
     */
    Post.prototype._addSection = function(id){
        var self = this;
        var sectionsTemp = new Array();
        for(i in self.sections){
            if(i > id){
                self.sections[i].id++;
            }
            sectionsTemp.push(self.sections[i]);
            if(i == id){
                var section = new Section({'id':id+1, 'title':'','imgs':[],'video':'','desc':''});
                sectionsTemp.push(section);
            }
        }
        //重绘　重新绑定
        self.sections = sectionsTemp;
        self._renderSections();
        //self._bindEvents();
    }


    Post.prototype._removeSection = function(id){
        var self = this;
        var sectionsTemp = new Array();
        for(i in self.sections){
            if(i == id){
                continue;
            }
            if(i > id){
                self.sections[i].id--;
            }
            sectionsTemp.push(self.sections[i]);
        }

        //重绘　重新绑定
        self.sections = sectionsTemp;
        self._renderSections();
        //self._bindEvents();
    }

    Post.prototype._serialize = function(){
        //形成json 字符串
        var self = this;
        var data = new Array();
        for(i in self.sections){
            data.push(self.sections[i]);
        }
        return JSON.stringify(data);
    }
    w.Post = Post;
})(window, jQuery, Section, UploadImg);

$(function(){

    var data = $('#post-content').val()?JSON.parse($('#post-content').val()):[];
    var options = {'id':'post-content', 'data' : data};
    var post = new Post(options);
    $('#w0').submit(function(){
        console.log($(this));
        //序列化　post
        var value = post._serialize();
        $('#post-content').val(value);
    });
})
