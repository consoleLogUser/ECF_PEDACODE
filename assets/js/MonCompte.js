
let user = []
let HTML = language
let CSS = language
let JS = language
let JX = language


// fonction pour les barres de progrès, pris d'une database et à ajouter au visuel
function generateProgressBars(user) {
    const { html, css, js, jx } = getUserProgressFromDatabase(user);

    const htmlProgress = generateProgressBar('HTML', html);
    const cssProgress = generateProgressBar('CSS', css);
    const jsProgress = generateProgressBar('JavaScript', js);
    const jxProgress = generateProgressBar('Jx', jx);

    return [htmlProgress, cssProgress, jsProgress, jxProgress];
}
function generateProgressBar(language, progress) {
    // pour générer et actualiser le progrès
    return `${language}: [${'#'.repeat(progress / 10)}${'-'.repeat(10 - progress / 10)}] ${progress}%`;
}