var shortcut = {
    // (A) SET SHORTCUT KEYS TO LISTEN TO
    listen : null,
    set : (listen) => {
        // (A1) KEY SEQUENCE + FUNCTION TO RUN
        shortcut.listen = listen;
    
        // (A2) KEY PRESS LISTENERS
        window.addEventListener("keydown", (evt) => {
            shortcut.track(evt.key.toLowerCase(), true);
        });
        window.addEventListener("keyup", (evt) => {
            shortcut.track(evt.key.toLowerCase(), false);
        });
    },
  
    // (B) KEY PRESS SEQUENCE TRACKER
    sequence : [],
    track : (key, direction) => {
        // (B1) PREVENT AUTO CLEANING
        if (shortcut.junk != null) { clearTimeout(shortcut.junk); }
  
        if (direction) { if (!shortcut.sequence.includes(key)) {
            // (B2) KEY DOWN
            shortcut.sequence.push(key);
        }} else {
            // (B3) KEY UP
            let idx = shortcut.sequence.indexOf(key);
            if (idx != -1) { shortcut.sequence.splice(idx, 1); }
        }
  
        // (B4) HIT SHORTCUT?
        if (shortcut.sequence.length != 0) {
            let seq = shortcut.sequence.join("-");
            if (shortcut.listen[seq]) {
                shortcut.sequence = [];
                shortcut.listen[seq]();
            } else {
                // (B5) PREVENT "STUCK SEQUENCE" WHEN USER LEAVES PAGE
                // E.G. OPEN NEW TAB WHILE IN MIDDLE OF KEY PRESS SEQUENCE
                shortcut.junk = setTimeout(shortcut.clean, 600)
            }
        }
    },
  
    // (C) AUTO CLEANUP
    junk : null,
    clean : () => {
        shortcut.junk = null;
        shortcut.sequence = [];
    }
};