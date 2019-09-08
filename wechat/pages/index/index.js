//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    leader_message_id:72,
    about_id:74,
    child_id:3,
    education_id:4,
    exchange_id:2,
    media_id:13,
    teachers_id:14,
    mamababa_id:12,
    dream_id:11,
  },
  //事件处理函数
 
  onLoad: function () {
  },

  toDetail:function(e){
    console.log(e);
    var url;

    if (e.currentTarget.dataset.wxlink) {
      url = "../wxlink/wxlink?id=" + e.currentTarget.id+"&type=pages";
    }
    else {
      url = "../detail/detail?id=" + e.currentTarget.id + "&type=pages";
    }
    wx.navigateTo({
      url: url,
    });
  },

  toList:function(e){
    console.log(e);
    var url = '../list/list?id=' + e.currentTarget.id;

    wx.navigateTo({
      url: url,
    })

  },

  toListImg: function (e) {
    console.log(e);
    var url = '../listimg/listimg?id=' + e.currentTarget.id;

    wx.navigateTo({
      url: url,
    })

  },
  
})
