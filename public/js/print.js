function printData() {
  var content = document.getElementById("printArea").innerHTML; // Ambil elemen dengan ID printArea
  var myWindow = window.open("", "", "height=500, width=800");
  myWindow.document.write("<html><head><title>Print Data Mahasiswa</title>");
  myWindow.document.write(
    "<style>table { width: 100%; border-collapse: collapse; } td, th { border: 1px solid black; padding: 8px; text-align: center; } th { background-color: #808080; color: white; }</style>"
  );
  myWindow.document.write("</head><body>");
  myWindow.document.write("<h2>Daftar Mahasiswa</h2>");
  myWindow.document.write("<div>" + content + "</div>");
  myWindow.document.write("</body></html>");
  myWindow.document.close();
  myWindow.print();
}
