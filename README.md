# Catalog2

Catalog2 is a flat-file (DBless) PHP application to manage your home library. If you don't care about who hosts your stuff, choose LibraryThing. If you want complex, almost library-like stuff, go for OpenBiblio, Koha or Evergreen. But if you want to own your book data and you would keep it simple without all the functionalities too much for an average user, Catalog2 is for you.

Catalog2 is a viable solution for managing small and mid-size home libraries.

## Features

With Catalog2, you can
- add new books with
	- title,
	- author(s),
	- ISBN number,
	- publisher,
	- year of publishing,
	- genre(s),
	- cover image,
	- description and
	- location;
- edit and delete existing books;
- manage books lent based on
	- who did you lend it to and
	- when did you lend it;
- browse your collection based on
	- authors,
	- publishers,
	- years of publishing,
	- genres,
	- document types (book vs ebook) and
	- lent status;
- manage your ebooks with ebook file upload;
- search your collection based on all fields or only certain fields;
- protect your data from unwanted eyes with built-in authentication;
- import book data from Google Books (API Key required).

## Requirements

- PHP 7.0+

## Installation, backup and forgotten password

### Installation

1. Download and unpack the `.zip` or clone this repository.
2. Rename the top level folder to your liking (eg. `catalog2`).
3. Upload the folder to the desired location on your web server.
	- Make sure that your `data/ebooks` folder's permissions are set to `755`.
4. Visit the folder in your browser (eg. `http://example.com/catalog2`).
5. Provide a username, a password and your Google Books API Key (latter is optional).
6. Click the button and you're done. Have fun.

### Backups

To back up your data, make sure that you regularly make a copy of the following files and folders:

- `application/config/config.yml`
- `data/*`

`config.yml` stores your credentials and Google Books API Key, while the `data` folder stores all the data of your collection.

### Forgotten password

Since your password is stored as a salted-hashed string, there is no way to recover it.

If you forgot your password, refer to the below process. Your data remains intact, however it is always a good idea to back up your `data` folder before taking actions like this.

1. Visit your Catalog2 folder on your web server via FTP.
2. Remove the file `application/config/config.yml`;
	- your Google  Books API Key will also be lost.
3. Visit your Catalog2 instance via browser.
4. You will be redirected to `register.php`.
5. Re-register yourself.
6. You will be redirected to the Login screen, where you can log in with your new credentials.

## Third-party code

For licensing information of the third-party components please see `THIRDPARTY.md`.

## License

Catalog2 is released under the MIT License. Full text of the license can be found in the `LICENSE.md` file.
