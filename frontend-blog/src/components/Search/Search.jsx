import Styles from './Search.module.css';

const Search = () => {
  return (
    <div className={Styles.search_container}>
        <form>
        <input type="text" name="" id="" placeholder='Search' />
        <button className={Styles.container_btn}>Go</button>            
        </form>
    </div>
  )
}

export default Search
