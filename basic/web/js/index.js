/**
 * Created by sun on 8/26/15.
 */

//文章编辑模块

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
        var html = '<div id="section-'+self.id+'" class="section-item">';
        html += '<div class="section-title"><span>'+self.id+'</span><input type="text" value="'+self.title+'" /></div>';
        html += '<div class="section-video"><input type="text" value="'+self.title+'"></div>';
        var imgHtml = '';
        for(i in self.imgs){
            imgHtml += '<div class="section-img"><img src="'+self.imgs[i]+'"></div>';
        }
        html += '<div class="section-imgs">'+imgHtml+' <div class="add-img">加图<div></div>';
        html += '<div class="section-desc"><textarea row="3">'+self.desc+'</textarea></div>';
        html += '</div>';

        return html;
    }

    Section.prototype._toJson = function(){
        var self = this;
        return {title : self.title, imgs : self.imgs, desc : self.desc};
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

(function(w,$, Section){

    // section :{string title, array imgs, string desc} 标题, 图片组, 描述
    // options.id , options.data;
    function Post(options){
        var self = this;
        self.id = options.id;
        var data = options.data;

        self.sections = new Array();

        for(i in data){
            data[i].id = i;
            self.sections.push(new Section(data[i]));
        }

        self.$el = $('#post-content-wrap');

        self._init();
    }

    /**
     * 初始化
     * @private
     */


    Post.prototype._init = function(){
        var self = this;
        self._render();
    }

    Post.prototype._render = function(){
        var self = this;
        var html = "<div id='post-content-wrap' class='form-control post-edit-contaner'>";

        for(i in self.sections){
            var h = self.sections[i]._render();
            html += h;
        }
        html += '<div class="add-step">增加</div>';
        html += '</div>';
        $('#'+self.id).after(html);
        $('#'+self.id).hide();
    }

    Post.prototype.addSection = function(){}


    w.Post = Post;
})(window, jQuery, Section);


$(function(){
    var data = new Array({'title' : '标题', 'imgs':['https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=1242215395,2575055316&fm=116&gp=0.jpg','https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=2651666712,3423349209&fm=116&gp=0.jpg'], 'desc':'描述', 'video':''},{'title' : '标题2', 'imgs':[], 'desc':'描述2', 'video':''},{'title' : '标题2', 'imgs':[], 'desc':'描述2', 'video':''});
    var options = {'id':'post-content', 'data' : data};
     post = new Post(options);
})
