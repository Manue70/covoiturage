import fs from "fs";
import path from "path";

const src = path.resolve("public/assets/css/style.css");
const dest = path.resolve("../backend/public/assets/css/style.css");

function copyCSS() {
  fs.copyFile(src, dest, (err) => {
    if (err) {
      console.error("❌ Erreur copie CSS :", err);
    } else {
      console.log("✅ CSS copié dans le backend !");
    }
  });
}

// Lancement immédiat + watch
copyCSS();
fs.watch(src, copyCSS);
