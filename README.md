# 全局方法

## 提示框

```
//跳转并生成 msg 闪存session，将触发一个全局提示（3秒后自动关闭）
return back()->with('msg', '提示信息!');
```