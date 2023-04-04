
import Styles from './NavBar.module.css';
import Search from '../Search/Search';

const NavBar = () => {
  return (
    <nav >
        <div >
            <ul className={Styles.nav_links}>
                <li><a href="#">Home</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">About</a></li>
            </ul>

        </div>
        <div className="search">
            <Search />
        </div>
      
    </nav>
  )
}

export default NavBar
