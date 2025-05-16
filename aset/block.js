
// Block.js
// Block right click, copy, paste, cut, select
	document.addEventListener("contextmenu", e => e.preventDefault());
	document.addEventListener("keydown", e => {
		if (e.ctrlKey && ["c", "x", "v", "u"].includes(e.key) ||
			e.key === "F12" || (e.ctrlKey && e.shiftKey && ["I", "J", "C"].includes(e.key))) {
			e.preventDefault();
		}
	});
	document.addEventListener("selectstart", e => e.preventDefault());