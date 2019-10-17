#### Compiling Xlswriter in ubuntu
*the php extend named xlswriter is a reader and writer of xlsx, developed by [Viest](https://github.com/viest), [document](https://xlswriter-docs.viest.me/zh-cn/). As you see, the Article I will write almost like the part of document. If you feel boring, the article you can ignore immediately.*

##### Downloading the demo from github
- to execute the command: `git clone https://github.com/viest/php-ext-excel-export`;
   
##### Downloading submodule
- typing `cd php-ext-excel-export`;
- and download submodule, `git submodule update --init`, this stage may use more time, so you can drink a coffee to relax;

##### Creating php configure file
- using `/usr/local/php/bin/phpize` to check php;
- to create a configure file `./configure --with-php-config=/usr/local/php/bin/php-config --enable-reader`;
   
##### Compiling and installing
- if above stages not break, you can `sudo make && sudo make install` next;
   
##### To enable the extend
- Inserting `extension = xlswriter.so` to your php.ini;
- And then, you can use `php --ri=xlswriter` to see the extend info built just now.

##### Some notices
- Because of installed before, I don't need to install a lib named `zlib1g-dev` again. If you install this extend first, you can use `sudo apt-get install zlib1g-dev` to install a lib.
   
Awkwardly, I think I need four or five coffees during downloading submodule. Emmm...it wastes half of hour, downloading too long...

##### Read a xlsx file practice
- Getting a xlsx
    ```php
    /** a xlsx file name */
    $fileName = 'tmp.xlsx';
    /** a dir of xlsx */
    $config = ['path' => './'];
    /** to get excel object */
    $excel = new \Vtiful\Kernel\Excel($config);
    /** to open a sheet */
    $excel->openFile($fileName)->openSheet();
    ```
- Reading all
    ```php
    /** to get all data from the Excel obj read from a xlsx file */
    $excel->getSheetData();
    ```
- Reading by vernier
   ```php
     /** to get next row data */
     $excel->nextRow();
   ```
- Reading by cell callback
   ```php
     /** to get a cell by callback  */
     $excel->->nextCellCallback(function ($row, $cell, $data) {});
   ```
- Creating a xlsx
   ```php
     $config   = ['path' => './'];
     $excel    = new \Vtiful\Kernel\Excel($config);
     /** warning, the data to xlsx must be a number index */
     $data = [[12, 'fda']];
     $filePath = $excel->fileName('test.xlsx', 'sheet1')
         ->header(['a', 'b'])
         ->data($data)
         ->output();
   ```
Oh, it's a sweet smell. if you want to know more methods, please to see **[xlswriter document](https://xlswriter-docs.viest.me/)**.