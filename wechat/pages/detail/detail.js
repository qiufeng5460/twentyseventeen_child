// pages/detail/detail.js
var WxParse = require('../../wxParse/wxParse.js');

Page({

  /**
   * 页面的初始数据
   */
  data: {
      title:'',
      wxlink:'',
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log(options);
    var self=this;
    self.getArticle(options.id,options.type);
  },


  getArticle:function(id,type){
    if(!id)
    return;

    var self=this;
    var HOST_URL = 'https://dx7y.fun/wp-json/wp/v2/';
    var url = HOST_URL+type+'/'+id;

    wx.request({
      url: url,
      success(res){
        console.log(res);
        if(res.statusCode===200){
          WxParse.wxParse('articleContent', 'html', res.data.content.rendered, self, 5);
          self.setData({
            title: res.data.title.rendered,
          });
        }
        else{
          console.log('status code fail!');
        }
      },
      fail(e){
        console.log(e);
      },
    })
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