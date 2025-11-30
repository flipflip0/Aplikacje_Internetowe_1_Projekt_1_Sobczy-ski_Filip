const availableStyles: { [key: string]: string } = {
    'Klasyczny': 'style-1.css',
    '\tCiemny': 'style-2.css',
    '\tZmodyfikowany': 'style-3.css',
};

let currentStyleName: string = 'Klasyczny';

function loadStyle(fileName: string): void {
    const head = document.getElementsByTagName('head')[0];
    
    const oldLink = document.getElementById('zen-style-link');
    if (oldLink) {
        head.removeChild(oldLink);
    }

    const newLink = document.createElement('link');
    newLink.rel = 'stylesheet';
    newLink.type = 'text/css';
    newLink.href = 'public/' + fileName;
    newLink.id = 'zen-style-link';

    head.appendChild(newLink);
}

function switchStyle(styleName: string): void {
    const fileName = availableStyles[styleName];

    if (fileName) {
        loadStyle(fileName);
        currentStyleName = styleName;
        console.log(`Przełączono styl na: ${currentStyleName} (${fileName})`);
    } else {
        console.error(`Styl o nazwie '${styleName}' nie istnieje.`);
    }
}

function createStyleSwitcher(): void {
    const nav = document.createElement('nav');
    nav.classList.add('style-switcher');
    
    const title = document.createElement('h3');
    title.textContent = 'Wybierz Styl:';
    nav.appendChild(title);

    for (const name in availableStyles) {
        const link = document.createElement('a');
        link.href = '#';
        link.textContent = name;
        link.classList.add('style-link');
        
        link.addEventListener('click', (event) => {
            event.preventDefault();
            switchStyle(name);
        });

        nav.appendChild(link);
    }
    
    const footer = document.querySelector('footer');
    if (footer) {
        footer.prepend(nav);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    loadStyle(availableStyles[currentStyleName]);
    
    createStyleSwitcher();
});