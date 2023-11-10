import { createRouter, createWebHistory } from 'vue-router'

import Home from './components/admin/Home.vue'

import Products from './components/admin/products/Index.vue'
import DeactivatedProducts from './components/admin/products/IndexDeactivated.vue'
import ProductMaster from './components/admin/products/Master.vue'

import Categories from './components/admin/categories/Index.vue'
import CategoryCreate from './components/admin/categories/Create.vue'
import CategoryEdit from './components/admin/categories/Edit.vue'

import Colors from './components/admin/colors/Index.vue'
import ColorMaster from './components/admin/colors/Master.vue'

import Styles from './components/admin/styles/Index.vue'
import StyleMaster from './components/admin/styles/Master.vue'

import Factories from './components/admin/factories/Index.vue'
import FactoryMaster from './components/admin/factories/Master.vue'

import Constructs from './components/admin/constructs/Index.vue'
import ConstructMaster from './components/admin/constructs/Master.vue'

import Surfaces from './components/admin/surfaces/Index.vue'
import SurfaceCreate from './components/admin/surfaces/Create.vue'
import SurfaceEdit from './components/admin/surfaces/Edit.vue'

import Types from './components/admin/types/Index.vue'
import TypeCreate from './components/admin/types/Create.vue'
import TypeEdit from './components/admin/types/Edit.vue'

import Purposes from './components/admin/purposes/Index.vue'
import PurposeCreate from './components/admin/purposes/Create.vue'
import PurposeEdit from './components/admin/purposes/Edit.vue'

import InnerDecors from './components/admin/innerdecors/Index.vue'
import InnerDecorCreate from './components/admin/innerdecors/Create.vue'
import InnerDecorEdit from './components/admin/innerdecors/Edit.vue'

import FurnitureTypes from './components/admin/furnituretypes/Index.vue'
import FurnitureTypeCreate from './components/admin/furnituretypes/Create.vue'
import FurnitureTypeEdit from './components/admin/furnituretypes/Edit.vue'

import Glasses from './components/admin/glasses/Index.vue'
import GlassCreate from './components/admin/glasses/Create.vue'
import GlassEdit from './components/admin/glasses/Edit.vue'

import MainSlider from './components/admin/mainslider/Index.vue'
import MainSlideCreate from './components/admin/mainslider/Create.vue'
import MainSlideEdit from './components/admin/mainslider/Edit.vue'

import Leads from './components/admin/leads/Index.vue'
import Lead from './components/admin/leads/Lead.vue'

import Reviews from './components/admin/reviews/Index.vue'

import Pages from './components/admin/pages/Index.vue'
import PageEdit from './components/admin/pages/Edit.vue'

const routes = [
    {
        path: '/admin',
        name: 'Home',
        component: Home
    },
    {
        path: '/admin/products',
        name: 'Products',
        component: Products
    },
    {
        path: '/admin/deactivated-products',
        name: 'DeactivatedProducts',
        component: DeactivatedProducts
    },
    {
        path: '/admin/product-master/:id?',
        name: 'ProductMaster',
        component: ProductMaster
    },
    {
        path: '/admin/categories',
        name: 'Categories',
        component: Categories
    },
    {
        path: '/admin/categories/create',
        name: 'CategoryCreate',
        component: CategoryCreate
    },
    {
        path: '/admin/category/:id',
        name: 'CategoryEdit',
        component: CategoryEdit
    },
    {
        path: '/admin/colors',
        name: 'Colors',
        component: Colors
    },
    {
        path: '/admin/color-master/:id?',
        name: 'ColorMaster',
        component: ColorMaster
    },
    {
        path: '/admin/styles',
        name: 'Styles',
        component: Styles
    },
    {
        path: '/admin/style-master/:id?',
        name: 'StyleMaster',
        component: StyleMaster
    },
    {
        path: '/admin/factories',
        name: 'Factories',
        component: Factories
    },
    {
        path: '/admin/factory-master/:id?',
        name: 'FactoryMaster',
        component: FactoryMaster
    },
    {
        path: '/admin/constructs',
        name: 'Constructs',
        component: Constructs
    },
    {
        path: '/admin/construct-master/:id?',
        name: 'ConstructMaster',
        component: ConstructMaster
    },
    {
        path: '/admin/surfaces',
        name: 'Surfaces',
        component: Surfaces
    },
    {
        path: '/admin/surfaces/create',
        name: 'SurfaceCreate',
        component: SurfaceCreate
    },
    {
        path: '/admin/surface/:id',
        name: 'SurfaceEdit',
        component: SurfaceEdit
    },
    {
        path: '/admin/types',
        name: 'Types',
        component: Types
    },
    {
        path: '/admin/types/create',
        name: 'TypeCreate',
        component: TypeCreate
    },
    {
        path: '/admin/type/:id',
        name: 'TypeEdit',
        component: TypeEdit
    },
    {
        path: '/admin/purposes',
        name: 'Purposes',
        component: Purposes
    },
    {
        path: '/admin/purposes/create',
        name: 'PurposeCreate',
        component: PurposeCreate
    },
    {
        path: '/admin/purpose/:id',
        name: 'PurposeEdit',
        component: PurposeEdit
    },
    {
        path: '/admin/innerdecors',
        name: 'InnerDecors',
        component: InnerDecors
    },
    {
        path: '/admin/innerdecors/create',
        name: 'InnerDecorCreate',
        component: InnerDecorCreate
    },
    {
        path: '/admin/innerdecor/:id',
        name: 'InnerDecorEdit',
        component: InnerDecorEdit
    },
    {
        path: '/admin/furnituretypes',
        name: 'FurnitureTypes',
        component: FurnitureTypes
    },
    {
        path: '/admin/furnituretypes/create',
        name: 'FurnitureTypeCreate',
        component: FurnitureTypeCreate
    },
    {
        path: '/admin/furnituretype/:id',
        name: 'FurnitureTypeEdit',
        component: FurnitureTypeEdit
    },
    {
        path: '/admin/glasses',
        name: 'Glasses',
        component: Glasses
    },
    {
        path: '/admin/glasses/create',
        name: 'GlassCreate',
        component: GlassCreate
    },
    {
        path: '/admin/glass/:id',
        name: 'GlassEdit',
        component: GlassEdit
    },
    {
        path: '/admin/mainslider',
        name: 'MainSlider',
        component: MainSlider
    },
    {
        path: '/admin/mainslider/create',
        name: 'MainSlideCreate',
        component: MainSlideCreate
    },
    {
        path: '/admin/mainslide/:id',
        name: 'MainSlideEdit',
        component: MainSlideEdit
    },
    {
        path: '/admin/leads',
        name: 'Leads',
        component: Leads
    },
    {
        path: '/admin/lead/:id',
        name: 'Lead',
        component: Lead
    },
    {
        path: '/admin/reviews',
        name: 'Reviews',
        component: Reviews
    },
    {
        path: '/admin/pages',
        name: 'Pages',
        component: Pages
    },
    {
        path: '/admin/page/:id',
        name: 'PageEdit',
        component: PageEdit
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})