// pages/list/list.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
     post_title:'',
     post_date:'',
     post_length:0,
     cat_name:'',
     page:1,
     page_count:10,
     last_page:false,
     post_list:[],
     more:'none',  
     cat_id:0,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var self=this;

    self.setData({
      cat_id: options.id,
    });
    self.setBarTitle(options.id);

  },

  listPost:function(id){
    if (!id)
      return;
    var self=this;
    var HOST_URI = 'https://dx7y.fun/wp-json/wp/v2/';
    var url = HOST_URI + 'posts?categories=' + id + '&page=' + self.data.page;

    wx.request({
      url: url,
      success(res){
        console.log(res);
        if(res.statusCode===200){
          //如果收到的数据数组长度小于希望的长度（page_count=10）则表明是最后一页

          self.setData({
            post_list:self.data.post_list.concat(res.data.map(function(item){
              var strdate = item.date;
              item.date = strdate.substr(0, 10);
              return item;
            })),

          });

          if (res.data.length < self.data.page_count) {
            self.setData({ last_page: true });
            self.setData({ more: 'none' });
          }
          else{
            self.setData({ last_page: false });
            self.setData({ more: 'block' });
          }  

        }
        else{
          //rest_post_invalid_page_number：请求的页码大于总页数
          if (res.data.code == "rest_post_invalid_page_number") {
            self.setData({ last_page: true });
            self.setData({ more: 'none' });
          }
        }
      },
      fail(e){
        console.log(e);
      }
    });

  },

  setBarTitle:function(id){
    if (!id)
      return;
    var self = this;
    var HOST_URI = 'https://dx7y.fun/wp-json/wp/v2/categories/';
    var url = HOST_URI + id;

    wx.request({
      url: url,
      success(res){
        console.log(res);
        if(res.statusCode===200){
           self.setData({
             post_length:res.data.count,
             cat_name:res.data.name,
           });
          wx.setNavigationBarTitle({
            title: res.data.name,
          });

          if (res.data.count){
             self.listPost(id);
          }
        }
        else{
          console.log("statusCode fail");
        }
      },
      fail(e){
        console.log(e);
      },
    })
  },

  getMore:function(){
    if(this.data.last_page)
    return;

    this.setData({ page: this.data.page + 1 });
    this.listPost(this.data.cat_id);
  },

  toDetail: function (e) {
    console.log(e);
    var url; 
    
    if (e.currentTarget.dataset.wxlink) {
      url = "../wxlink/wxlink?id=" + e.currentTarget.id + "&type=posts";
    }
    else {
      url = "../detail/detail?id=" + e.currentTarget.id + "&type=posts";
    }
    console.log(url);
    wx.navigateTo({
      url: url,
    });
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})