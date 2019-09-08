// pages/listimg/listimg.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    post_length: 0,
    cat_name: '',
    page: 1,
    page_count: 6,
    last_page: false,
    post_list: [],
    more: 'none',
    cat_id: 0,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var self = this;

    self.setData({
      cat_id: options.id,
    });
    self.setBarTitle(options.id);
  },

  setBarTitle: function (id) {
    if (!id)
      return;
    var self = this;
    var HOST_URI = 'https://dx7y.fun/wp-json/wp/v2/categories/';
    var url = HOST_URI + id;

    wx.request({
      url: url,
      success(res) {
        console.log(res);
        if (res.statusCode === 200) {
          self.setData({
            post_length: res.data.count,
            cat_name: res.data.name,
          });
          wx.setNavigationBarTitle({
            title: res.data.name,
          });

          if (res.data.count) {
            self.listPost(id);
          }
        }
        else {
          console.log("statusCode fail");
        }
      },
      fail(e) {
        console.log(e);
      },
    })
  },

  listPost: function (id) {
    if (!id)
      return;
    var self = this;
    var HOST_URI = 'https://dx7y.fun/wp-json/wp/v2/';
    var url = HOST_URI + 'posts?categories=' + id + '&page=' + self.data.page + '&per_page=' + self.data.page_count;

    wx.request({
      url: url,
      success(res) {
        console.log(res);
        if (res.statusCode === 200) {

          self.setData({
            post_list: self.data.post_list.concat(res.data.map(function (item) {
              var str = item.excerpt.rendered;
              item.excerpt.rendered = self.matchReg(str);
              return item;
            })),

          });
          //如果收到的数据数组长度小于希望的长度（page_count=10）则表明是最后一页
          if (res.data.length < self.data.page_count) {
            self.setData({ last_page: true });
            self.setData({ more: 'none' });
          }
          else {
            self.setData({ last_page: false });
            self.setData({ more: 'block' });
          }

        }
        else {
          //rest_post_invalid_page_number：请求的页码大于总页数
          if (res.data.code == "rest_post_invalid_page_number") {
            self.setData({ last_page: true });
            self.setData({ more: 'none' });
          }
        }
      },
      fail(e) {
        console.log(e);
      }
    });

  },

  getMore: function () {
    if (this.data.last_page)
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
    wx.navigateTo({
      url: url,
    });
  },
  
  /**
   * 20190907:使用正则表达式去除所有html标签只保留文字
  1.<div class="test"></div>
  2.<img />
  3.自定义标签<My-Tag></My-Tag>
  针对以上几种标签，确定的正则的规则是 reg=/<\/?.+?\/?>/g
  <表示尖括号
  第一个\/?表示</div>这种标签的情况
  .+?表示将中间所有内容替代掉
  第二个\/?表示<img/>这种情况
  /g表示全局替换
  */
  matchReg:function(str){
    let reg = /<\/?.+?\/?>/g;
    return str.replace(reg,'');
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