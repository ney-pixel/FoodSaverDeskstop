const { app, BrowserWindow } = require("electron");

function createWindow() {
  const win = new BrowserWindow({
    width: 1200,
    height: 800,
    backgroundColor: "#000",
  });

  win.loadURL("http://localhost:8000/view/index/index.html");
}

app.whenReady().then(createWindow);