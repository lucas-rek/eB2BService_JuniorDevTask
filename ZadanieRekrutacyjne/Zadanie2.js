
/*
 * Poniższa metoda mogłaby też przyjmować jeden argumenty typu 'User'
 * i wykorzystywana za pomocą forEach dla listy użytkowników. W ten sposób miała by
 * zastosowanie dla 2 typów danych.
 */
/**
 * Ta funkcja wita użytkowników poprzez konsolę.
 * @param array lista użytkowników typu 'User'
 */
function welcomeUsers(array) {
    // Proste sprawdzenie argumentu
    if(!Array.isArray(array)) {
        throw "Array not passed as argument!"
    }
    if(array.length === 0 ) {
        console.log("The array of users is empty!")
    }
    // W ten sposób oszczędzamy czas na możliwe wielokrotne wezwanie tej samej metody
    let year = new Date().getFullYear();
    array.forEach( (element) => {
        if(!(element instanceof User)) {
            throw "Invalid user type";
        }
        if(element.salary > 15000) {
            console.log("Witaj, prezesie!");
        } else if(element.salary < 5000) {
            console.log(`${element.username}, szykuj się na podwyżkę!`);
        } else if(element.birthYear % 2 === 0) {
            console.log(`Witaj, ${element.username}! W tym roku kończysz ${year-element.birthYear} lat!`);
        } else if(element.birthYear % 2 === 1){
            console.log(`${element.username}, jesteś zwolniony!`);
        } else {
            // Domyślna opcja dla niepasujących obiektów.
            console.log(`${JSON.stringify(element)} could not be parsed`);
        }
    })

}


function User(username, birthYear, salary) {
    this.username = username;
    this.birthYear = birthYear;
    this.salary = salary;
}

let array = [new User('Jan Kowalski', 1983, 4200), new User('Anna Nowak', 1994, 7500),
    new User('Jakub Jakubowski', 1985, 18000), new User('Piotr Kozak', 2000, 4999),
    new User('Marek Sinica', 1989, 7200), new User('Kamila Wiśniewska', 1972, 6800),
    new User('Imię Nazwisko', "Rok 1234", "Kwota Brutto 12345")];


welcomeUsers(array);
welcomeUsers([]);
// Przypadki, które powinny wywołać błąd.
// welcomeUsers(new User('Jan Kowalski', 1983, 4200));
// welcomeUsers(['jan', 78]);