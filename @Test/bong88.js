var IeVer = (function () {
  var c, d = 3, b = document.createElement("div"), a = b.getElementsByTagName("i");
  while (b.innerHTML = "<!--[if gt IE " + (++d) + "]><i></i><![endif]-->", a[0]) {
  }
  return d > 4 ? d : c
}());
function fxn(a, b) {
  if (a.keyCode == 13) {
    if (b == "D") {
      return callSubmit("", "D")
    } else {
      if (!checkValidationCode()) {
        return false
      }
    }
  }
}
function checkValidationCode() {
  var a;
  a = document.getElementById("txtCode");
  if (a.value == "") {
    a.focus();
    alert(error_validation);
    return false
  }
  var b = new Object();
  b.txtCode = $("#txtCode").val();
  $.ajax({url: "checkValidateLogin.ashx", async: false, cache: false, type: "GET", dataType: "json", data: {txtCode: b.txtCode}, success: function (c) {
    var d = c.ValidateCheck;
    if (d == false) {
      alert(c.Msg.replace("\\n", "\n"));
      $("#validateCode_href").click();
      CodeReset();
      return false
    } else {
      return callSubmit("", "V")
    }
  }})
}
function callSubmit(a, e) {
	alert('hello'); return;
  var h;
  var b;
  var d;
  var i;
  var c;
  var g;
  h = document.getElementById("txtID");
  if (h.value == "") {
    h.focus();
    alert(error_username);
    return false
  }
  i = document.getElementById("txtPW");
  if (i.value == "") {
    i.focus();
    alert(error_password);
    return false
  }
  c = document.getElementById("txtCode");
  if (c.value == "") {
    c.focus();
    alert(error_validation);
    return false
  }
  if (e == "D" || e == "O") {
    b = CFS(i.value);
    d = b + c.value;
    i.value = MD5(d)
  }
  g = document.getElementById("hidubmit");
  if (g != null) {
    g.value = a
  }
  if (IeVer != undefined && document.getElementById("IEVerison") != null) {
    document.getElementById("IEVerison").value = IeVer
  }
  ping("detecResponseTime.aspx", function (f) {
    if (f.status == "success") {
      document.getElementById("detecResTime").value = f.ackTime
    }
  }, false);
  document.frmLogin.submit();
  return false
};